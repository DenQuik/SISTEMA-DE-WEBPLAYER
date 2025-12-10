<?php require_once __DIR__ . '/../inc/main.php'; ?>
<?php
$selected = (int)($_GET['genero_id'] ?? 0);
$db = conexion();
$genres = $db->query("SELECT genero_id, genero_nombre FROM genero ORDER BY genero_nombre ASC")->fetchAll();
$songs = [];
if($selected>0){
    $songs = $db->query("SELECT cancion_id, cancion_titulo, cancion_archivo FROM cancion WHERE genero_id='".$selected."' ORDER BY cancion_titulo ASC")->fetchAll();
}
$db = null;
?>
<?php
# Archivo: genero_search.php
# Propósito: Mostrar canciones filtradas por género
?>
<div class="container is-fluid mb-6">
    <h1>­</h1>
    <h1 class="title">Buscar por Género</h1>
    <h2 class="subtitle">Selecciona un género para ver sus canciones</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="columns">
        <div class="column is-4">
            <form method="GET" action="index.php">
                <input type="hidden" name="vista" value="genero_search">
                <div class="field">
                    <label class="label">Género</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="genero_id" onchange="this.form.submit()">
                                <option value="0">-- Seleccione --</option>
                                <?php foreach($genres as $g): ?>
                                    <option value="<?php echo $g['genero_id']; ?>" <?php echo ($selected==$g['genero_id'])?'selected':''; ?>><?php echo htmlspecialchars($g['genero_nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            <div class="form-rest mb-4"></div>
        </div>

        <div class="column is-8">
            <h3 class="title is-6">Canciones</h3>
            <div class="box">
                <?php if($selected<=0): ?>
                    <div class="notification is-light">Seleccione un género para listar sus canciones.</div>
                <?php else: ?>
                    <?php if(count($songs)==0): ?>
                        <div class="notification is-warning">No se encontraron canciones para este género.</div>
                    <?php else: ?>
                        <?php foreach($songs as $s): ?>
                            <div class="level">
                                <div class="level-left">
                                    <div class="level-item">
                                        <?php echo htmlspecialchars($s['cancion_titulo']); ?>
                                    </div>
                                </div>
                                <div class="level-right">
                                    <div class="level-item">
                                        <?php if(!empty($s['cancion_archivo'])): ?>
                                            <audio controls src="<?php echo htmlspecialchars($s['cancion_archivo'], ENT_QUOTES); ?>" preload="none"></audio>
                                        <?php else: ?>
                                            <span class="tag is-light">Sin archivo</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
