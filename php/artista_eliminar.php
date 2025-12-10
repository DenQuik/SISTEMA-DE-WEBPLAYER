<?php
# Archivo: artista_eliminar.php
# Propósito: Elimina un artista y su foto asociada
require_once __DIR__ . '/../inc/session_start.php';
require_once __DIR__ . '/../inc/main.php';

if($_SERVER['REQUEST_METHOD']!=='POST'){
    echo error_alert('Metodo no permitido.');
    exit;
}

$id = (int) ($_POST['artista_id_del'] ?? 0);
if($id<=0){
    echo error_alert('Identificador no válido.');
    exit;
}

// verificar existencia y propietario
$check = conexion();
$res = $check->query("SELECT artista_foto, usuario_id FROM artista WHERE artista_id='$id'");
if($res->rowCount()<=0){
    echo error_alert('El artista no existe.');
    exit;
}
$row = $res->fetch();
$usuario_actual = $_SESSION['id'] ?? 0;
if($usuario_actual<=0){
    echo error_alert('Debe iniciar sesión para eliminar.');
    exit;
}
if($row['usuario_id'] != $usuario_actual && $usuario_actual != 1){
    echo error_alert('No tienes permiso para eliminar este artista.');
    exit;
}
$foto = $row['artista_foto'];

// eliminar registro
$del = conexion();
$stmt = $del->prepare("DELETE FROM artista WHERE artista_id=:id");
if($stmt->execute([':id'=>$id])){
    if(!empty($foto) && file_exists(__DIR__ . '/../' . $foto)){
        @unlink(__DIR__ . '/../' . $foto);
    }
    echo success_alert('Artista eliminado correctamente.');
}else{
    echo error_alert('No se pudo eliminar el artista.');
}
$del = null;

?>
