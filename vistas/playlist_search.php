<?php require_once __DIR__ . '/../inc/main.php'; ?>
<?php
$selected = (int)($_GET['playlist_id'] ?? 0);
$db = conexion();
$playlists = $db->query("SELECT playlist_id, playlist_nombre FROM playlist ORDER BY playlist_nombre ASC")->fetchAll();
// all songs
$songs = $db->query("SELECT cancion_id, cancion_titulo FROM cancion ORDER BY cancion_titulo ASC")->fetchAll();
$assoc = [];
if($selected>0){
    $rows = $db->query("SELECT cancion_id FROM playlist_cancion WHERE playlist_id='$selected'")->fetchAll();
    foreach($rows as $r) $assoc[(int)$r['cancion_id']] = true;
}
$db = null;
?>
<div class="container is-fluid mb-6">
    <h1>­</h1>
    <h1 class="title">Buscar/Administrar Playlist</h1>
    <h2 class="subtitle">Selecciona una playlist para agregar o quitar canciones</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="columns">
        <div class="column is-4">
            <form method="GET" action="index.php">
                <input type="hidden" name="vista" value="playlist_search">
                <div class="field">
                    <label class="label">Playlist</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="playlist_id" onchange="this.form.submit()">
                                <option value="0">-- Seleccione --</option>
                                <?php foreach($playlists as $p): ?>
                                    <option value="<?php echo $p['playlist_id']; ?>" <?php echo ($selected==$p['playlist_id'])?'selected':''; ?>><?php echo htmlspecialchars($p['playlist_nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            <div class="form-rest mb-4"></div>

            <?php if($selected>0): ?>
                <h3 class="title is-6">Canciones en la playlist</h3>
                <div class="box">
                    <?php
                        $db2 = conexion();
                        $ps = $db2->query("SELECT pc.playlistc_id, c.cancion_id, c.cancion_titulo FROM playlist_cancion pc JOIN cancion c ON pc.cancion_id=c.cancion_id WHERE pc.playlist_id='$selected' ORDER BY pc.playlistc_orden ASC");
                        $ps = $ps->fetchAll();
                        foreach($ps as $row){
                            ?>
                            <div class="level">
                                <div class="level-left">
                                    <div class="level-item">
                                        <?php echo htmlspecialchars($row['cancion_titulo']); ?>
                                    </div>
                                </div>
                                <div class="level-right">
                                    <div class="level-item">
                                        <form class="FormularioAjax" action="./php/playlist_cancion_eliminar.php" method="POST">
                                            <input type="hidden" name="playlist_id" value="<?php echo $selected; ?>">
                                            <input type="hidden" name="cancion_id" value="<?php echo $row['cancion_id']; ?>">
                                            <button class="button is-danger is-small" type="submit">Quitar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        $db2 = null;
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="column is-8">
            <h3 class="title is-6">Todas las canciones</h3>
            <div class="box">
                <?php foreach($songs as $s): ?>
                    <div class="level">
                        <div class="level-left">
                            <div class="level-item">
                                <?php echo htmlspecialchars($s['cancion_titulo']); ?>
                            </div>
                        </div>
                        <div class="level-right">
                            <div class="level-item">
                                <?php if($selected>0): ?>
                                    <?php if(isset($assoc[$s['cancion_id']])): ?>
                                        <form class="FormularioAjax" action="./php/playlist_cancion_eliminar.php" method="POST" style="display:inline-block;">
                                            <input type="hidden" name="playlist_id" value="<?php echo $selected; ?>">
                                            <input type="hidden" name="cancion_id" value="<?php echo $s['cancion_id']; ?>">
                                            <button class="button is-warning is-small" type="submit">Quitar</button>
                                        </form>
                                    <?php else: ?>
                                        <form class="FormularioAjax" action="./php/playlist_cancion_guardar.php" method="POST" style="display:inline-block;">
                                            <input type="hidden" name="playlist_id" value="<?php echo $selected; ?>">
                                            <input type="hidden" name="cancion_id" value="<?php echo $s['cancion_id']; ?>">
                                            <button class="button is-info is-small" type="submit">Agregar</button>
                                        </form>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="tag is-light">Seleccione una playlist</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>
