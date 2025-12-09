<?php require_once __DIR__ . '/../inc/main.php'; ?>
<?php
    $cancion_id = (int)($_GET['cancion_id_up'] ?? 0);
    $db = conexion();
    $check = $db->query("SELECT * FROM cancion WHERE cancion_id='$cancion_id'");
    if($check->rowCount()<=0){
        echo '<div class="notification is-danger is-light">La cancion no existe</div>';
        return;
    }
    $song = $check->fetch();
    $db = null;
?>

<div class="container is-fluid mb-6">
    <h1>­</h1>
    <h1 class="title">Editar Cancion</h1>
    <h2 class="subtitle">Modificar datos</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/cancion_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="cancion_id" value="<?php echo $song['cancion_id']; ?>">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Titulo</label>
                    <input class="input" type="text" name="cancion_titulo" value="<?php echo htmlspecialchars($song['cancion_titulo']); ?>" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Artista</label>
                    <div class="select is-fullwidth">
                        <select name="artista_id" required>
                            <?php
                                $db = conexion();
                                $arts = $db->query("SELECT artista_id, artista_nombre FROM artista ORDER BY artista_nombre ASC");
                                foreach($arts->fetchAll() as $a){
                                    $sel = ($a['artista_id']==$song['artista_id'])?' selected':'';
                                    echo '<option value="'.$a['artista_id'].'"'.$sel.'>'.$a['artista_nombre'].'</option>';
                                }
                                $db = null;
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Genero</label>
                    <div class="select is-fullwidth">
                        <select name="genero_id" required>
                            <?php
                                $db = conexion();
                                $gens = $db->query("SELECT genero_id, genero_nombre FROM genero ORDER BY genero_nombre ASC");
                                foreach($gens->fetchAll() as $g){
                                    $sel = ($g['genero_id']==$song['genero_id'])?' selected':'';
                                    echo '<option value="'.$g['genero_id'].'"'.$sel.'>'.$g['genero_nombre'].'</option>';
                                }
                                $db = null;
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Album</label>
                    <div class="select is-fullwidth">
                        <select name="album_id">
                            <option value="0">Sin album</option>
                            <?php
                                $db = conexion();
                                $als = $db->query("SELECT album_id, album_titulo FROM album ORDER BY album_titulo ASC");
                                foreach($als->fetchAll() as $al){
                                    $sel = ($al['album_id']==$song['album_id'])?' selected':'';
                                    echo '<option value="'.$al['album_id'].'"'.$sel.'>'.$al['album_titulo'].'</option>';
                                }
                                $db = null;
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Nueva portada (opcional)</label>
                    <input class="input" type="file" name="cancion_foto" accept="image/*">
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Reemplazar archivo de audio (opcional)</label>
                    <input class="input" type="file" name="cancion_archivo" accept="audio/*">
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Actualizar</button>
        </p>
    </form>
</div>
