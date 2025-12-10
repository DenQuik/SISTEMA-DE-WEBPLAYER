<?php
# Archivo: genero_guardar.php
# Propósito: Guardar nuevo género
require_once __DIR__ . '/../inc/main.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo error_alert('Método no permitido.');
    exit;
}

$nombre = limpiar_cadena($_POST['genero_nombre'] ?? '');
$descripcion = limpiar_cadena($_POST['genero_descripcion'] ?? '');

if(empty($nombre)){
    echo error_alert('El nombre del género es obligatorio.');
    exit;
}

if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{2,50}", $nombre)){
    echo error_alert('Nombre de género no válido.');
    exit;
}

try{
    $db = conexion();
    $stmt = $db->prepare("INSERT INTO genero (genero_nombre, genero_descripcion) VALUES (:nombre, :descripcion)");
    $stmt->execute([':nombre'=>$nombre, ':descripcion'=>$descripcion]);
    echo success_alert('Género creado correctamente.');
}catch(PDOException $e){
    echo error_alert('Error en la base de datos: '.$e->getMessage());
}

?>
