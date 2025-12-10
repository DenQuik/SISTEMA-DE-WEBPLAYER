<?php
# Archivo: playlist_cancion_eliminar.php
# Propósito: Elimina la asociación canción-playlist (tabla playlist_cancion)
# Entrada: playlist_id y cancion_id por POST
# Salida: HTML de notificación para `FormularioAjax`
require_once __DIR__ . '/../inc/session_start.php';
require_once __DIR__ . '/../inc/main.php';

$playlist_id = (int)($_POST['playlist_id'] ?? 0);
$cancion_id = (int)($_POST['cancion_id'] ?? 0);

if($playlist_id<=0 || $cancion_id<=0){
    echo '<div class="notification is-danger is-light"><strong>¡Error!</strong><br>Faltan datos obligatorios</div>';
    exit();
}

$db = conexion();
$del = $db->prepare("DELETE FROM playlist_cancion WHERE playlist_id=:pl AND cancion_id=:can");
$del->execute([':pl'=>$playlist_id,':can'=>$cancion_id]);
if($del->rowCount()>0){
    echo '<div class="notification is-info is-light"><strong>¡ELIMINADO!</strong><br>La canción fue removida de la playlist</div>';
}else{
    echo '<div class="notification is-warning is-light"><strong>¡Atencion!</strong><br>La canción no estaba en la playlist</div>';
}
$db = null;
?>