<?php
# Archivo: playlist_actualizar.php
# Propósito: Actualiza los datos de una playlist (titulo, portadas, etc.)
# Entrada: datos por POST y FILES opcionalmente
# Salida: HTML de notificación para `FormularioAjax`
    require_once __DIR__ . '/../inc/session_start.php';
    require_once __DIR__ . '/../inc/main.php';

    $id = (int)($_POST['playlist_id'] ?? 0);
    $check = conexion();
    $check = $check->query("SELECT * FROM playlist WHERE playlist_id='$id'");
    if($check->rowCount()<=0){
        echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>La playlist no existe</div>';
        exit();
    }
    $datos = $check->fetch();
    $check = null;

    $nombre = limpiar_cadena($_POST['playlist_nombre'] ?? '');
    $descripcion = limpiar_cadena($_POST['playlist_descripcion'] ?? '');

    if($nombre==""){
        echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>Faltan datos obligatorios</div>';
        exit();
    }

    # Preparar ruta de la foto actual; si se sube nueva se reemplaza #
    $ruta_foto = $datos['playlist_foto'];
    if(isset($_FILES['playlist_foto']) && $_FILES['playlist_foto']['error']===0){
        $file = $_FILES['playlist_foto'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];
        $maxBytes = 2 * 1024 * 1024;
        if(in_array($ext, $allowed) && $file['size'] <= $maxBytes){
            if(!empty($ruta_foto) && file_exists(__DIR__ . '/../' . $ruta_foto)){
                @unlink(__DIR__ . '/../' . $ruta_foto);
            }
            $nombreImg = renombrar_fotos(pathinfo($file['name'], PATHINFO_FILENAME)).'.'.$ext;
            $dest = __DIR__ . '/../uploads/playlist_portadas/' . $nombreImg;
            if(move_uploaded_file($file['tmp_name'], $dest)){
                $ruta_foto = 'uploads/playlist_portadas/' . $nombreImg;
            }
        }
    }

    $db = conexion();
    $stmt = $db->prepare("UPDATE playlist SET playlist_nombre=:nombre, playlist_descripcion=:descripcion, playlist_foto=:foto WHERE playlist_id=:id");
    $params = [':nombre'=>$nombre,':descripcion'=>$descripcion,':foto'=>$ruta_foto,':id'=>$id];
    if($stmt->execute($params)){
        echo '<div class="notification is-info is-light"><strong>¡PLAYLIST ACTUALIZADA!</strong><br>Los datos se actualizaron con exito</div>';
    }else{
        echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>No se pudo actualizar la playlist</div>';
    }
    $db = null;

?>
