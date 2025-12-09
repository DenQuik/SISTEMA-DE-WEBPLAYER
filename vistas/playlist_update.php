<?php require_once __DIR__ . '/../inc/main.php'; ?>
<?php
    $playlist_id = (int)($_GET['playlist_id_up'] ?? 0);
    $db = conexion();
    $check = $db->query("SELECT * FROM playlist WHERE playlist_id='$playlist_id'");
    if($check->rowCount()<=0){
        echo '<div class="notification is-danger is-light">La playlist no existe</div>';
        return;
    }
    $pl = $check->fetch();
    $db = null;
?>

<div class="container is-fluid mb-6">
    <h1>­</h1>
    <h1 class="title">Editar Playlist</h1>
    <h2 class="subtitle">Modificar datos</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/playlist_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="playlist_id" value="<?php echo $pl['playlist_id']; ?>">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="playlist_nombre" value="<?php echo htmlspecialchars($pl['playlist_nombre']); ?>" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Descripcion</label>
                    <input class="input" type="text" name="playlist_descripcion" value="<?php echo htmlspecialchars($pl['playlist_descripcion']); ?>">
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nueva foto (opcional)</label>
                    <input class="input" type="file" name="playlist_foto" accept="image/*">
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Actualizar</button>
        </p>
    </form>
</div>
