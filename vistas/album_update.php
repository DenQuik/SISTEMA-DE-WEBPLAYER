<?php
# Archivo: album_update.php
# Propósito: Formulario para editar un album
require_once __DIR__ . '/../inc/main.php';
?>
<?php
    $album_id = (int)($_GET['album_id_up'] ?? 0);
    $db = conexion();
    $check = $db->query("SELECT * FROM album WHERE album_id='$album_id'");
    if($check->rowCount()<=0){
        echo '<div class="notification is-danger is-light">El album no existe</div>';
        return;
    }
    $al = $check->fetch();
    $db = null;
?>

<div class="container is-fluid mb-6">
    <h1>­</h1>
    <h1 class="title">Editar Album</h1>
    <h2 class="subtitle">Modificar datos</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/album_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="album_id" value="<?php echo $al['album_id']; ?>">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Titulo</label>
                    <input class="input" type="text" name="album_titulo" value="<?php echo htmlspecialchars($al['album_titulo']); ?>" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Año</label>
                    <input class="input" type="number" name="album_year" value="<?php echo htmlspecialchars($al['album_year']); ?>" min="1900" max="2100" required>
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
                                    $sel = ($a['artista_id']==$al['artista_id'])? ' selected':'';
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
                    <label>Nueva portada (opcional)</label>
                    <input class="input" type="file" name="album_portada" accept="image/*">
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Actualizar</button>
        </p>
    </form>
</div>
