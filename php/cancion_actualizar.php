<?php
    require_once __DIR__ . '/../inc/session_start.php';
    require_once __DIR__ . '/../inc/main.php';

    $id = (int) ($_POST['cancion_id'] ?? 0);

    $check = conexion();
    $check = $check->query("SELECT * FROM cancion WHERE cancion_id='$id'");
    if($check->rowCount()<=0){
        echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>La cancion no existe</div>';
        exit();
    }else{
        $datos = $check->fetch();
    }
    $check = null;

    $titulo = limpiar_cadena($_POST['cancion_titulo'] ?? '');
    $artista = (int) ($_POST['artista_id'] ?? 0);
    $genero = (int) ($_POST['genero_id'] ?? 0);
    $album = (int) ($_POST['album_id'] ?? 0);

    if($titulo=="" || $artista<=0 || $genero<=0){
        echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>Faltan datos obligatorios</div>';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{2,100}", $titulo)){
        echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>Titulo no valido</div>';
        exit();
    }

    $ruta_audio = $datos['cancion_archivo'];
    if(isset($_FILES['cancion_archivo']) && $_FILES['cancion_archivo']['error']===0){
        $file = $_FILES['cancion_archivo'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['mp3','m4a','ogg','wav'];
        $maxBytes = 25 * 1024 * 1024;
        if(in_array($ext, $allowed) && $file['size'] <= $maxBytes){
            // eliminar anterior
            if(!empty($ruta_audio) && file_exists(__DIR__ . '/../' . $ruta_audio)){
                @unlink(__DIR__ . '/../' . $ruta_audio);
            }
            $nombreAudio = time()."_".preg_replace('/[^A-Za-z0-9_.-]/','_', $file['name']);
            $dest = __DIR__ . '/../uploads/canciones/' . $nombreAudio;
            if(move_uploaded_file($file['tmp_name'], $dest)){
                $ruta_audio = 'uploads/canciones/' . $nombreAudio;
            }
        }
    }

    $ruta_portada = $datos['cancion_foto'];
    if(isset($_FILES['cancion_foto']) && $_FILES['cancion_foto']['error']===0){
        $file = $_FILES['cancion_foto'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];
        $maxBytes = 2 * 1024 * 1024;
        if(in_array($ext, $allowed) && $file['size'] <= $maxBytes){
            if(!empty($ruta_portada) && file_exists(__DIR__ . '/../' . $ruta_portada)){
                @unlink(__DIR__ . '/../' . $ruta_portada);
            }
            $nombreImg = renombrar_fotos(pathinfo($file['name'], PATHINFO_FILENAME)).'.'.$ext;
            $dest = __DIR__ . '/../uploads/cancion_portadas/' . $nombreImg;
            if(move_uploaded_file($file['tmp_name'], $dest)){
                $ruta_portada = 'uploads/cancion_portadas/' . $nombreImg;
            }
        }
    }

    $upd = conexion();
    $stmt = $upd->prepare("UPDATE cancion SET cancion_titulo=:titulo, artista_id=:artista, genero_id=:genero, album_id=:album, cancion_archivo=:archivo, cancion_foto=:foto WHERE cancion_id=:id");
    $params = [
        ':titulo'=>$titulo,
        ':artista'=>$artista,
        ':genero'=>$genero,
        ':album'=>$album,
        ':archivo'=>$ruta_audio,
        ':foto'=>$ruta_portada,
        ':id'=>$id
    ];

    if($stmt->execute($params)){
        echo '<div class="notification is-info is-light"><strong>¡CANCIÓN ACTUALIZADA!</strong><br>Los datos se actualizaron correctamente</div>';
    }else{
        echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>No se pudo actualizar la canción</div>';
    }
    $upd = null;

?>
