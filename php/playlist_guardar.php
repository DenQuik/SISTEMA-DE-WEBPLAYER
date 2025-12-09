<?php
    require_once __DIR__ . '/../inc/session_start.php';
    require_once __DIR__ . '/../inc/main.php';

    $nombre = limpiar_cadena($_POST['playlist_nombre'] ?? '');
    $descripcion = limpiar_cadena($_POST['playlist_descripcion'] ?? '');
    $usuario = $_SESSION['id'] ?? 0;

    if($nombre==""){
        echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>Faltan datos obligatorios</div>';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{2,70}", $nombre)){
        echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>Nombre no valido</div>';
        exit();
    }

    $ruta_foto = '';
    if(isset($_FILES['playlist_foto']) && $_FILES['playlist_foto']['error']===0){
        $file = $_FILES['playlist_foto'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];
        $maxBytes = 2 * 1024 * 1024;
        if(in_array($ext, $allowed) && $file['size'] <= $maxBytes){
            $nombreImg = renombrar_fotos(pathinfo($file['name'], PATHINFO_FILENAME)).'.'.$ext;
            $dest = __DIR__ . '/../uploads/playlist_portadas/' . $nombreImg;
            if(move_uploaded_file($file['tmp_name'], $dest)){
                $ruta_foto = 'uploads/playlist_portadas/' . $nombreImg;
            }
        }
    }

    $db = conexion();
    $stmt = $db->prepare("INSERT INTO playlist(playlist_nombre,playlist_descripcion,playlist_foto,usuario_id) VALUES(:nombre,:descripcion,:foto,:usuario)");
    $params = [':nombre'=>$nombre,':descripcion'=>$descripcion,':foto'=>$ruta_foto,':usuario'=>$usuario];
    if($stmt->execute($params)){
        echo '<div class="notification is-info is-light"><strong>¡PLAYLIST CREADA!</strong><br>La playlist fue creada con exito</div>';
    }else{
        echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>No se pudo crear la playlist</div>';
    }
    $db = null;

?>
