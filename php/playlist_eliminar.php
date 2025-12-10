<?php
    # Archivo: playlist_eliminar.php
    # Propósito: Elimina una playlist y su portada asociada si aplica
    # Entrada: playlist_id por POST
    # Salida: HTML de notificación para `FormularioAjax`
    $playlist_id_del = limpiar_cadena($_GET['playlist_id_del'] ?? '');
    # Eliminar playlist: borrar foto física (si existe) y registro en BD #

    $check = conexion();
    $check = $check->query("SELECT playlist_foto FROM playlist WHERE playlist_id='$playlist_id_del'");
    if($check->rowCount()==1){
        $datos = $check->fetch();
        if(!empty($datos['playlist_foto']) && file_exists(__DIR__ . '/../' . $datos['playlist_foto'])){
            @unlink(__DIR__ . '/../' . $datos['playlist_foto']);
        }
        $eliminar = conexion();
        $eliminar = $eliminar->prepare("DELETE FROM playlist WHERE playlist_id=:id");
        $eliminar->execute([":id"=>$playlist_id_del]);
        if($eliminar->rowCount()==1){
            echo '<div class="notification is-info is-light"><strong>¡PLAYLIST ELIMINADA!</strong><br>La playlist se elimino con exito</div>';
        }else{
            echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>No se pudo eliminar la playlist</div>';
        }
        $eliminar = null;
    }else{
        echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>La playlist que intenta eliminar no existe</div>';
    }
    $check = null;

?>
