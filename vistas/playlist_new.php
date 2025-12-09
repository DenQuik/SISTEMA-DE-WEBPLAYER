<?php require_once __DIR__ . '/../inc/main.php'; ?>
<div class="container is-fluid mb-6">
    <h1>­</h1>
    <h1 class="title">Playlist</h1>
    <h2 class="subtitle">Crear nueva playlist</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/playlist_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="playlist_nombre" maxlength="40" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Descripcion</label>
                    <input class="input" type="text" name="playlist_descripcion" maxlength="70">
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Foto (opcional)</label>
                    <input class="input" type="file" name="playlist_foto" accept="image/*">
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>
