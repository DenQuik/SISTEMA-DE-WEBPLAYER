<?php
# Archivo: play_history.php
# Propósito: Mostrar historial de reproducciones si existe la tabla `play_history`.
# Si la tabla no existe, muestra un fallback con las últimas canciones.
require_once __DIR__ . '/../inc/session_start.php';
require_once __DIR__ . '/../inc/main.php';
?>

<div class="container is-fluid mb-6">
    <h1>­</h1>
    <h1 class="title">Historial de Reproducciones</h1>
    <h2 class="subtitle">Últimas pistas reproducidas por los usuarios</h2>
</div>

<div class="container pb-6 pt-6">
<?php
    $db = null;
    try{
        $db = conexion();
        // Comprobar si existe tabla `play_history`
        $check = $db->query("SHOW TABLES LIKE 'play_history'")->fetchAll();
        if(count($check)>0){
                // Asumimos columnas: id, usuario_id, cancion_id, played_at (si existe)
                $usuarioFiltro = $_SESSION['id'] ?? 0;
                if($usuarioFiltro>0){
                    $sql = "SELECT ph.*, c.cancion_titulo, a.artista_nombre FROM play_history ph LEFT JOIN cancion c ON ph.cancion_id=c.cancion_id LEFT JOIN artista a ON c.artista_id=a.artista_id WHERE ph.usuario_id='".intval($usuarioFiltro)."' ORDER BY ph.played_at DESC LIMIT 50";
                }else{
                    $sql = "SELECT ph.*, c.cancion_titulo, a.artista_nombre FROM play_history ph LEFT JOIN cancion c ON ph.cancion_id=c.cancion_id LEFT JOIN artista a ON c.artista_id=a.artista_id ORDER BY ph.played_at DESC LIMIT 50";
                }
            $rows = $db->query($sql)->fetchAll();
            if(count($rows)>0){
                echo '<div class="box">';
                echo '<ol>';
                foreach($rows as $r){
                    $title = htmlspecialchars($r['cancion_titulo'] ?? '(sin título)');
                    $artist = !empty($r['artista_nombre']) ? ' — ' . htmlspecialchars($r['artista_nombre']) : '';
                    $time = isset($r['played_at']) ? ' <small class="has-text-grey">'.htmlspecialchars($r['played_at']).'</small>' : '';
                    echo '<li style="margin-bottom:10px;">'.$title.$artist.$time.'</li>';
                }
                echo '</ol>';
                echo '</div>';
            }else{
                echo '<div class="notification is-warning is-light">No hay reproducciones registradas aún.</div>';
            }
        }else{
            // Fallback: mostrar últimas canciones añadidas
            $rows = $db->query("SELECT c.cancion_id, c.cancion_titulo, a.artista_nombre FROM cancion c LEFT JOIN artista a ON c.artista_id=a.artista_id ORDER BY c.cancion_id DESC LIMIT 20")->fetchAll();
            echo '<div class="notification is-info is-light">La tabla <strong>play_history</strong> no está disponible. Mostrando últimas canciones como fallback.</div>';
            if(count($rows)>0){
                echo '<div class="box"><ol>';
                foreach($rows as $r){
                    $title = htmlspecialchars($r['cancion_titulo']);
                    $artist = !empty($r['artista_nombre']) ? ' — ' . htmlspecialchars($r['artista_nombre']) : '';
                    echo '<li style="margin-bottom:10px;">'.$title.$artist.'</li>';
                }
                echo '</ol></div>';
            }else{
                echo '<div class="notification is-warning is-light">No hay canciones registradas aún.</div>';
            }
        }
    }catch(Exception $e){
        echo '<div class="notification is-danger is-light">Ocurrió un error al cargar el historial.</div>';
    }finally{
        if($db) $db = null;
    }
?>
</div>
