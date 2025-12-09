<?php
    /*== Almacenando datos ==*/
    $cancion_id_del = limpiar_cadena($_GET['cancion_id_del'] ?? '');

    /*== Verificando existencia ==*/
    $check = conexion();
    $check = $check->query("SELECT cancion_archivo,cancion_foto FROM cancion WHERE cancion_id='$cancion_id_del'");
    if($check->rowCount()==1){
        $datos = $check->fetch();

        // eliminar archivos fisicos
        if(!empty($datos['cancion_archivo']) && file_exists(__DIR__ . '/../' . $datos['cancion_archivo'])){
            @unlink(__DIR__ . '/../' . $datos['cancion_archivo']);
        }
        if(!empty($datos['cancion_foto']) && file_exists(__DIR__ . '/../' . $datos['cancion_foto'])){
            @unlink(__DIR__ . '/../' . $datos['cancion_foto']);
        }

        $eliminar = conexion();
        $eliminar = $eliminar->prepare("DELETE FROM cancion WHERE cancion_id=:id");
        $eliminar->execute([":id"=>$cancion_id_del]);

        if($eliminar->rowCount()==1){
            echo '<div class="notification is-info is-light"><strong>¡CANCIÓN ELIMINADA!</strong><br>Los datos de la canción se eliminaron con exito</div>';
        }else{
            echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>No se pudo eliminar la canción</div>';
        }
        $eliminar = null;
    }else{
        echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>La canción que intenta eliminar no existe</div>';
    }
    $check = null;

?>
