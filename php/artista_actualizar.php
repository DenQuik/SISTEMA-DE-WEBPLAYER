<?php
# Archivo: artista_actualizar.php
# Propósito: Actualiza datos de un artista (nombre, bio, foto)
require_once __DIR__ . '/../inc/session_start.php';
require_once __DIR__ . '/../inc/main.php';

if($_SERVER['REQUEST_METHOD']!=='POST'){
    echo error_alert('Metodo no permitido.');
    exit;
}

$id = (int) ($_POST['artista_id'] ?? 0);
// verificar existencia
$check = conexion();
$res = $check->query("SELECT * FROM artista WHERE artista_id='$id'");
if($res->rowCount()<=0){
    echo error_alert('El artista no existe.');
    exit;
}
$datos = $res->fetch();
$check = null;

// permiso: solo el propietario o admin (id 1) puede modificar
$usuario_actual = $_SESSION['id'] ?? 0;
if($usuario_actual<=0){
    echo error_alert('Debe iniciar sesión para actualizar.');
    exit;
}
if($datos['usuario_id'] != $usuario_actual && $usuario_actual != 1){
    echo error_alert('No tienes permiso para editar este artista.');
    exit;
}

$nombre = limpiar_cadena($_POST['artista_nombre'] ?? '');
$bio = limpiar_cadena($_POST['artista_biografia'] ?? '');

if(empty($nombre)){
    echo error_alert('El nombre es obligatorio.');
    exit;
}

$ruta_foto = $datos['artista_foto'];
if(isset($_FILES['artista_foto']) && $_FILES['artista_foto']['error']===0){
    $file = $_FILES['artista_foto'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif'];
    $maxBytes = 2 * 1024 * 1024;
    if(in_array($ext, $allowed) && $file['size'] <= $maxBytes){
        if(!empty($ruta_foto) && file_exists(__DIR__ . '/../' . $ruta_foto)){
            @unlink(__DIR__ . '/../' . $ruta_foto);
        }
        $nombreImg = renombrar_fotos(pathinfo($file['name'], PATHINFO_FILENAME)).'.'.$ext;
        $dest = __DIR__ . '/../uploads/artista_fotos/' . $nombreImg;
        if(move_uploaded_file($file['tmp_name'], $dest)){
            $ruta_foto = 'uploads/artista_fotos/' . $nombreImg;
        }
    }
}

$upd = conexion();
$stmt = $upd->prepare("UPDATE artista SET artista_nombre=:nombre, artista_biografia=:bio, artista_foto=:foto WHERE artista_id=:id");
$params = [':nombre'=>$nombre, ':bio'=>$bio, ':foto'=>$ruta_foto, ':id'=>$id];
if($stmt->execute($params)){
    echo success_alert('Artista actualizado correctamente.');
}else{
    echo error_alert('No se pudo actualizar el artista.');
}
$upd = null;

?>
