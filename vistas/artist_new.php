<?php
# Archivo: artist_new.php
# Propósito: Formulario para crear un nuevo artista
require_once __DIR__ . '/../inc/main.php'; ?>
<div class="container is-fluid mb-6">
    <h1>­</h1>
    <h1 class="title">Artistas</h1>
    <h2 class="subtitle">Agregar nuevo artista</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/artista_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="artista_nombre" maxlength="50" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Biografía (opcional)</label>
                    <textarea class="textarea" name="artista_biografia" maxlength="100"></textarea>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Foto (jpg/png) - opcional</label>
                    <input class="input" type="file" name="artista_foto" accept="image/*">
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>
