<?php
# Archivo: genero_actualizar.php
# Propósito: Actualizar un género existente
require_once __DIR__ . '/../inc/main.php';

if($_SERVER['REQUEST_METHOD']!=='POST'){
    echo error_alert('Método no permitido.');
    exit;
}

$id = (int) ($_POST['genero_id'] ?? 0);
$nombre = limpiar_cadena($_POST['genero_nombre'] ?? '');
$descripcion = limpiar_cadena($_POST['genero_descripcion'] ?? '');

if($id<=0 || empty($nombre)){
    echo error_alert('Faltan datos obligatorios.');
    exit;
}

try{
    $db = conexion();
    $check = $db->query("SELECT * FROM genero WHERE genero_id='$id'");
    if($check->rowCount()<=0){
        echo error_alert('El género no existe.');
        exit;
    }
    $stmt = $db->prepare("UPDATE genero SET genero_nombre=:nombre, genero_descripcion=:descripcion WHERE genero_id=:id");
    $stmt->execute([':nombre'=>$nombre, ':descripcion'=>$descripcion, ':id'=>$id]);
    echo success_alert('Género actualizado correctamente.');
}catch(PDOException $e){
    echo error_alert('Error en la base de datos: '.$e->getMessage());
}

?>
