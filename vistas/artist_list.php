<?php
# Archivo: artist_list.php
# Propósito: Vista que muestra la lista de artistas (paginada)
    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $registros = 10;
    $busqueda = $_GET['busqueda'] ?? '';
    $url = 'index.php?vista=artist_list&pagina=';
?>
<div class="container is-fluid mb-6">
    <h1>­</h1>
    <h1 class="title">Artistas</h1>
    <h2 class="subtitle">Lista de artistas</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="level">
        <div class="level-left">
            <div class="level-item">
                <a href="index.php?vista=artist_new" class="button is-info is-rounded">Nuevo Artista</a>
            </div>
        </div>
        <div class="level-right">
            <div class="level-item">
                <form method="GET" action="index.php" class="field has-addons">
                    <input type="hidden" name="vista" value="artist_list">
                    <div class="control">
                        <input class="input" type="text" name="busqueda" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda); ?>">
                    </div>
                    <div class="control">
                        <button class="button is-info">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
        require_once __DIR__ . '/../inc/main.php';
        require_once __DIR__ . '/../php/artista_lista.php';
    ?>

</div>
