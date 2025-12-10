<?php
# Archivo: album_actualizar.php
# Propósito: Actualiza datos de un album (titulo, year, artista, portada)
require_once __DIR__ . '/../inc/session_start.php';
require_once __DIR__ . '/../inc/main.php';

if($_SERVER['REQUEST_METHOD']!=='POST'){
    echo error_alert('Metodo no permitido.');
    exit;
}

$id = (int) ($_POST['album_id'] ?? 0);
$check = conexion();
$res = $check->query("SELECT * FROM album WHERE album_id='$id'");
if($res->rowCount()<=0){
    echo error_alert('El album no existe.');
    exit;
}
$datos = $res->fetch();
$check = null;

// permiso: solo propietario o admin (id 1)
$usuario_actual = $_SESSION['id'] ?? 0;
if($usuario_actual<=0){
    echo error_alert('Debe iniciar sesión para actualizar.');
    exit;
}
if($datos['usuario_id'] != $usuario_actual && $usuario_actual != 1){
    echo error_alert('No tienes permiso para editar este album.');
    exit;
}

$titulo = limpiar_cadena($_POST['album_titulo'] ?? '');
$year = (int) ($_POST['album_year'] ?? 0);
$artista = (int) ($_POST['artista_id'] ?? 0);

if(empty($titulo) || $year<=0 || $artista<=0){
    echo error_alert('Faltan datos obligatorios.');
    exit;
}

$ruta_portada = $datos['album_portada'];
if(isset($_FILES['album_portada']) && $_FILES['album_portada']['error']===0){
    $file = $_FILES['album_portada'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif'];
    $maxBytes = 2 * 1024 * 1024;
    if(in_array($ext, $allowed) && $file['size'] <= $maxBytes){
        if(!empty($ruta_portada) && file_exists(__DIR__ . '/../' . $ruta_portada)){
            @unlink(__DIR__ . '/../' . $ruta_portada);
        }
        $nombreImg = renombrar_fotos(pathinfo($file['name'], PATHINFO_FILENAME)).'.'.$ext;
        $dest = __DIR__ . '/../uploads/album_portadas/' . $nombreImg;
        if(move_uploaded_file($file['tmp_name'], $dest)){
            $ruta_portada = 'uploads/album_portadas/' . $nombreImg;
        }
    }
}

$upd = conexion();
$stmt = $upd->prepare("UPDATE album SET album_titulo=:titulo, album_portada=:portada, album_year=:year, artista_id=:artista WHERE album_id=:id");
$params = [':titulo'=>$titulo, ':portada'=>$ruta_portada, ':year'=>$year, ':artista'=>$artista, ':id'=>$id];
if($stmt->execute($params)){
    echo success_alert('Album actualizado correctamente.');
}else{
    echo error_alert('No se pudo actualizar el album.');
}
$upd = null;

?>
