<?php
# Archivo: genero_update.php
# Propósito: Formulario para editar un género
require_once __DIR__ . '/../inc/main.php';
?>
<?php
    $genero_id = (int)($_GET['genero_id_up'] ?? 0);
    $db = conexion();
    $check = $db->query("SELECT * FROM genero WHERE genero_id='$genero_id'");
    if($check->rowCount()<=0){
        echo '<div class="notification is-danger is-light">El género no existe</div>';
        return;
    }
    $g = $check->fetch();
    $db = null;
?>

<div class="container is-fluid mb-6">
    <h1>­</h1>
    <h1 class="title">Editar Género</h1>
    <h2 class="subtitle">Modificar datos</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/genero_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off">
        <input type="hidden" name="genero_id" value="<?php echo $g['genero_id']; ?>">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="genero_nombre" value="<?php echo htmlspecialchars($g['genero_nombre']); ?>" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Descripción (opcional)</label>
                    <textarea class="textarea" name="genero_descripcion"><?php echo htmlspecialchars($g['genero_descripcion']); ?></textarea>
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Actualizar</button>
        </p>
    </form>
</div>
