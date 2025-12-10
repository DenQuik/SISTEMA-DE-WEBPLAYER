<?php
# Archivo: artist_update.php
# Propósito: Formulario para editar un artista
require_once __DIR__ . '/../inc/main.php';
?>
<?php
    $artista_id = (int)($_GET['artista_id_up'] ?? 0);
    $db = conexion();
    $check = $db->query("SELECT * FROM artista WHERE artista_id='$artista_id'");
    if($check->rowCount()<=0){
        echo '<div class="notification is-danger is-light">El artista no existe</div>';
        return;
    }
    $art = $check->fetch();
    $db = null;
?>

<div class="container is-fluid mb-6">
    <h1>­</h1>
    <h1 class="title">Editar Artista</h1>
    <h2 class="subtitle">Modificar datos</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/artista_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="artista_id" value="<?php echo $art['artista_id']; ?>">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="artista_nombre" value="<?php echo htmlspecialchars($art['artista_nombre']); ?>" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Biografía (opcional)</label>
                    <textarea class="textarea" name="artista_biografia"><?php echo htmlspecialchars($art['artista_biografia']); ?></textarea>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Nueva foto (opcional)</label>
                    <input class="input" type="file" name="artista_foto" accept="image/*">
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Actualizar</button>
        </p>
    </form>
</div>
