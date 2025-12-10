<?php
# Archivo: genero_eliminar.php
# Propósito: Eliminar un género
require_once __DIR__ . '/../inc/main.php';

if($_SERVER['REQUEST_METHOD']!=='POST'){
    echo error_alert('Método no permitido.');
    exit;
}

$id = (int) ($_POST['genero_id_del'] ?? 0);
if($id<=0){
    echo error_alert('Identificador no válido.');
    exit;
}

try{
    $db = conexion();
    $check = $db->query("SELECT genero_id FROM genero WHERE genero_id='$id'");
    if($check->rowCount()<=0){
        echo error_alert('El género no existe.');
        exit;
    }
    $stmt = $db->prepare("DELETE FROM genero WHERE genero_id=:id");
    if($stmt->execute([':id'=>$id])){
        echo success_alert('Género eliminado correctamente.');
    }else{
        echo error_alert('No se pudo eliminar el género.');
    }
}catch(PDOException $e){
    echo error_alert('Error en la base de datos: '.$e->getMessage());
}

?>
