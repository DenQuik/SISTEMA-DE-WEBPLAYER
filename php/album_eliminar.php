<?php
# Archivo: album_eliminar.php
# Propósito: Elimina un album y su portada
require_once __DIR__ . '/../inc/session_start.php';
require_once __DIR__ . '/../inc/main.php';

if($_SERVER['REQUEST_METHOD']!=='POST'){
    echo error_alert('Metodo no permitido.');
    exit;
}

$id = (int) ($_POST['album_id_del'] ?? 0);
if($id<=0){
    echo error_alert('Identificador no válido.');
    exit;
}

// verificar existencia y propietario
$check = conexion();
$res = $check->query("SELECT album_portada, usuario_id FROM album WHERE album_id='$id'");
if($res->rowCount()<=0){
    echo error_alert('El album no existe.');
    exit;
}
$row = $res->fetch();
$usuario_actual = $_SESSION['id'] ?? 0;
if($usuario_actual<=0){
    echo error_alert('Debe iniciar sesión para eliminar.');
    exit;
}
if($row['usuario_id'] != $usuario_actual && $usuario_actual != 1){
    echo error_alert('No tienes permiso para eliminar este album.');
    exit;
}
$portada = $row['album_portada'];

$del = conexion();
$stmt = $del->prepare("DELETE FROM album WHERE album_id=:id");
if($stmt->execute([':id'=>$id])){
    if(!empty($portada) && file_exists(__DIR__ . '/../' . $portada)){
        @unlink(__DIR__ . '/../' . $portada);
    }
    echo success_alert('Album eliminado correctamente.');
}else{
    echo error_alert('No se pudo eliminar el album.');
}
$del = null;

?>
