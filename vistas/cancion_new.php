<?php require_once __DIR__ . '/../inc/main.php'; ?>
<div class="container is-fluid mb-6">
    <h1>­</h1>
    <h1 class="title">Canciones</h1>
    <h2 class="subtitle">Agregar nueva canción</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/cancion_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Titulo</label>
                    <input class="input" type="text" name="cancion_titulo" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{2,100}" maxlength="100" required>
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
                    <label>Genero</label>
                    <div class="select is-fullwidth">
                        <select name="genero_id" required>
                            <option value="">Seleccione</option>
                            <?php
                                $db = conexion();
                                $gens = $db->query("SELECT genero_id, genero_nombre FROM genero ORDER BY genero_nombre ASC");
                                foreach($gens->fetchAll() as $g){
                                    echo '<option value="'.$g['genero_id'].'">'.$g['genero_nombre'].'</option>';
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
                    <label>Album (opcional)</label>
                    <div class="select is-fullwidth">
                        <select name="album_id">
                            <option value="0">Sin album</option>
                            <?php
                                $db = conexion();
                                $als = $db->query("SELECT album_id, album_titulo FROM album ORDER BY album_titulo ASC");
                                foreach($als->fetchAll() as $al){
                                    echo '<option value="'.$al['album_id'].'">'.$al['album_titulo'].'</option>';
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
                    <input class="input" type="file" name="cancion_foto" accept="image/*">
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Archivo de audio (mp3, m4a, ogg, wav)</label>
                    <input class="input" type="file" name="cancion_archivo" accept="audio/*" required>
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>
