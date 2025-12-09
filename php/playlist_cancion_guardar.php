<?php
require_once __DIR__ . '/../inc/session_start.php';
require_once __DIR__ . '/../inc/main.php';

$playlist_id = (int)($_POST['playlist_id'] ?? 0);
$cancion_id = (int)($_POST['cancion_id'] ?? 0);

if($playlist_id<=0 || $cancion_id<=0){
    echo '<div class="notification is-danger is-light"><strong>¡Error!</strong><br>Faltan datos obligatorios</div>';
    exit();
}

$db = conexion();
// verificar existencia
$check = $db->query("SELECT playlist_id FROM playlist WHERE playlist_id='$playlist_id'");
if($check->rowCount()<=0){
    echo '<div class="notification is-danger is-light"><strong>¡Error!</strong><br>La playlist no existe</div>';
    exit();
}

$check2 = $db->query("SELECT cancion_id FROM cancion WHERE cancion_id='$cancion_id'");
if($check2->rowCount()<=0){
    echo '<div class="notification is-danger is-light"><strong>¡Error!</strong><br>La cancion no existe</div>';
    exit();
}

// evitar duplicados
$exists = $db->query("SELECT playlistc_id FROM playlist_cancion WHERE playlist_id='$playlist_id' AND cancion_id='$cancion_id'");
if($exists->rowCount()>0){
    echo '<div class="notification is-warning is-light"><strong>¡Atencion!</strong><br>La canción ya está en la playlist</div>';
    exit();
}

// determinar orden
$ord = $db->query("SELECT MAX(playlistc_orden) FROM playlist_cancion WHERE playlist_id='$playlist_id'");
$maxo = (int) $ord->fetchColumn();
$orden = $maxo + 1;

$stmt = $db->prepare("INSERT INTO playlist_cancion(playlist_id,cancion_id,playlistc_orden) VALUES(:pl,:can,:orden)");
if($stmt->execute([':pl'=>$playlist_id,':can'=>$cancion_id,':orden'=>$orden])){
    echo '<div class="notification is-info is-light"><strong>¡AGREGADO!</strong><br>La canción fue añadida a la playlist</div>';
}else{
    echo '<div class="notification is-danger is-light"><strong>¡Error!</strong><br>No se pudo agregar la canción</div>';
}
$db = null;
?>