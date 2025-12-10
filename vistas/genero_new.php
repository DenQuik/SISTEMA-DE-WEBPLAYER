<?php
# Archivo: genero_new.php
# Propósito: Formulario para crear un nuevo género
require_once __DIR__ . '/../inc/main.php'; ?>
<div class="container is-fluid mb-6">
    <h1>­</h1>
    <h1 class="title">Géneros</h1>
    <h2 class="subtitle">Agregar nuevo género</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/genero_guardar.php" method="POST" class="FormularioAjax" autocomplete="off">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="genero_nombre" maxlength="50" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Descripción (opcional)</label>
                    <textarea class="textarea" name="genero_descripcion" maxlength="100"></textarea>
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>
