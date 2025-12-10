<?php
    # Archivo: cancion_guardar.php
    # Propósito: Recibe formulario para crear una nueva canción y guarda archivos (audio/portada)
    # Entrada: campos por POST y archivos por FILES
    # Salida: HTML de notificación compatible con `FormularioAjax`
    require_once __DIR__ . '/../inc/session_start.php';
    require_once __DIR__ . '/../inc/main.php';

    /*== Almacenando datos ==*/
    $titulo = limpiar_cadena($_POST['cancion_titulo'] ?? '');
    $artista = (int) ($_POST['artista_id'] ?? 0);
    $genero = (int) ($_POST['genero_id'] ?? 0);
    $album = (int) ($_POST['album_id'] ?? 0);
    $usuario = $_SESSION['id'] ?? 0;

    /*== Validaciones basicas ==*/
    if($titulo == "" || $artista<=0 || $genero<=0){
        echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>Faltan datos obligatorios</div>';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{2,100}", $titulo)){
        echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>Titulo no valido</div>';
        exit();
    }

    /*== Manejo de archivos ==*/
    # Guardar archivo de audio (verifica extensión y tamaño) #
    $ruta_audio = '';
    if(isset($_FILES['cancion_archivo']) && $_FILES['cancion_archivo']['error']===0){
        $file = $_FILES['cancion_archivo'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['mp3','m4a','ogg','wav'];
        $maxBytes = 25 * 1024 * 1024; // 25 MB
        if(!in_array($ext, $allowed)){
            echo '<div class="notification is-danger is-light"><strong>¡Error!</strong><br>Formato de audio no permitido</div>';
            exit();
        }
        if($file['size'] > $maxBytes){
            echo '<div class="notification is-danger is-light"><strong>¡Error!</strong><br>El audio excede el tamaño permitido (25MB)</div>';
            exit();
        }

        $nombreAudio = time()."_".preg_replace('/[^A-Za-z0-9_.-]/','_', $file['name']);
        $dest = __DIR__ . '/../uploads/canciones/' . $nombreAudio;
        if(!move_uploaded_file($file['tmp_name'], $dest)){
            echo '<div class="notification is-danger is-light"><strong>¡Error!</strong><br>No se pudo guardar el archivo de audio</div>';
            exit();
        }
        $ruta_audio = 'uploads/canciones/' . $nombreAudio;
    }else{
        echo '<div class="notification is-danger is-light"><strong>¡Error!</strong><br>No se envio archivo de audio</div>';
        exit();
    }

    $ruta_portada = '';
    # Guardar portada si se envía (imagen pequeña) #
    if(isset($_FILES['cancion_foto']) && $_FILES['cancion_foto']['error']===0){
        $file = $_FILES['cancion_foto'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];
        $maxBytes = 2 * 1024 * 1024; // 2 MB
        if(!in_array($ext, $allowed)){
            echo '<div class="notification is-warning is-light"><strong>¡Atencion!</strong><br>Formato de imagen no permitido, se omitira la portada</div>';
        }else{
            if($file['size'] <= $maxBytes){
                $nombreImg = renombrar_fotos(pathinfo($file['name'], PATHINFO_FILENAME)).'.'.$ext;
                $dest = __DIR__ . '/../uploads/cancion_portadas/' . $nombreImg;
                if(move_uploaded_file($file['tmp_name'], $dest)){
                    $ruta_portada = 'uploads/cancion_portadas/' . $nombreImg;
                }
            }
        }
    }

    /*== Guardando en DB ==*/
    $guardar = conexion();
    $sql = "INSERT INTO cancion(cancion_titulo,artista_id,genero_id,album_id,usuario_id,cancion_archivo,cancion_foto) VALUES(:titulo,:artista,:genero,:album,:usuario,:archivo,:foto)";
    $stmt = $guardar->prepare($sql);
    $params = [
        ':titulo' => $titulo,
        ':artista' => $artista,
        ':genero' => $genero,
        ':album' => $album,
        ':usuario' => $usuario,
        ':archivo' => $ruta_audio,
        ':foto' => $ruta_portada
    ];

    if($stmt->execute($params)){
        echo '<div class="notification is-info is-light"><strong>¡CANCIÓN AGREGADA!</strong><br>La canción se guardó con éxito</div>';
    }else{
        echo '<div class="notification is-danger is-light"><strong>¡Ocurrio un error inesperado!</strong><br>No se pudo guardar la canción</div>';
    }
    $guardar = null;

?>
