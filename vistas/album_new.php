<?php
# Archivo: album_new.php
# Propósito: Formulario para crear un nuevo album
require_once __DIR__ . '/../inc/main.php'; ?>
<div class="container is-fluid mb-6">
    <h1>­</h1>
    <h1 class="title">Albums</h1>
    <h2 class="subtitle">Agregar nuevo album</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/album_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Titulo</label>
                    <input class="input" type="text" name="album_titulo" maxlength="40" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Año</label>
                    <input class="input" type="number" name="album_year" min="1900" max="2100" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Artista</label>
                    <div class="select is-fullwidth">
                        <select name="artista_id" required>
                            <option value="">Seleccione</option>
                            <?php
                                $db = conexion();
                                $arts = $db->query("SELECT artista_id, artista_nombre FROM artista ORDER BY artista_nombre ASC");
                                foreach($arts->fetchAll() as $a){
                                    echo '<option value="'.$a['artista_id'].'">'.$a['artista_nombre'].'</option>';
                                }
                                $db = null;
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Portada (jpg/png) - opcional</label>
                    <input class="input" type="file" name="album_portada" accept="image/*">
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>
