<?php
# Archivo: cancion_playlist.php
# Propósito: Mostrar canciones de una playlist seleccionada y controles básicos de reproducción
# Uso: GET `playlist_id` para filtrar; si no se pasa, muestra selector de playlists
require_once __DIR__ . '/../inc/main.php';
?>

<div class="container is-fluid mb-6">
    <h1>­</h1>
    <h1 class="title">Canciones por Playlist</h1>
    <h2 class="subtitle">Ver y reproducir canciones dentro de una playlist</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        $db = conexion();
        $playlists = $db->query("SELECT playlist_id, playlist_nombre FROM playlist ORDER BY playlist_nombre ASC")->fetchAll();
        $selected = (int)($_GET['playlist_id'] ?? 0);
    ?>

    <div class="field">
        <label class="label">Seleccionar Playlist</label>
        <div class="control">
            <form method="GET" action="index.php" class="">
                <input type="hidden" name="vista" value="cancion_playlist">
                <div class="select">
                    <select name="playlist_id" onchange="this.form.submit()">
                        <option value="0">-- Seleccione --</option>
                        <?php foreach($playlists as $p): ?>
                            <option value="<?php echo $p['playlist_id']; ?>" <?php echo ($p['playlist_id']==$selected)?'selected':''; ?>><?php echo htmlspecialchars($p['playlist_nombre']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <?php 
    
    if($selected>0):
        // Traer canciones asociadas en orden si aplica
        $stmt = $db->prepare("SELECT pc.playlistc_orden, c.* FROM playlist_cancion pc JOIN cancion c ON pc.cancion_id=c.cancion_id WHERE pc.playlist_id=:pl ORDER BY pc.playlistc_orden ASC");
        $stmt->execute([':pl'=>$selected]);
        $songs = $stmt->fetchAll();

        if(count($songs)==0){
            echo '<div class="notification is-warning is-light">Esta playlist no contiene canciones.</div>';
        }else{
            echo '<div class="box">';
            echo '<ol>';
            foreach($songs as $s){
                $title = htmlspecialchars($s['cancion_titulo']);
                $artist = '';
                if(!empty($s['artista_id'])){
                    $artId = (int)$s['artista_id'];
                    $a = $db->query("SELECT artista_nombre FROM artista WHERE artista_id='".$artId."'")->fetch();
                    if($a && !empty($a['artista_nombre'])){
                        $artist = ' — '.htmlspecialchars($a['artista_nombre']);
                    }
                }
                $audio = !empty($s['cancion_archivo']) ? '<br><audio controls src="'.htmlspecialchars($s['cancion_archivo'],ENT_QUOTES).'" preload="none"></audio>' : '';
                echo '<li style="margin-bottom:12px;">'.$title.$artist.$audio;
                // Si el usuario es admin (id 1) o dueño podríamos mostrar opción de quitar (usa FormularioAjax)
                echo ' <div style="display:inline-block;margin-left:8px;">';
                echo '<form class="FormularioAjax" method="POST" action="./php/playlist_cancion_eliminar.php" style="display:inline;">';
                echo '<input type="hidden" name="playlist_id" value="'.$selected.'">';
                echo '<input type="hidden" name="cancion_id" value="'.$s['cancion_id'].'">';
                echo '<button type="submit" class="button is-small is-danger is-rounded">Quitar</button>';
                echo '</form>';
                echo '</div>';
                echo '</li>';
            }
            echo '</ol>';
            echo '</div>';
        }
    endif;
    $db = null;
    ?>
</div>
