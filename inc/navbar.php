<nav class="navbar is-dark" role="navigation" aria-label="main navigation">

    <div class="navbar-brand">
        <a class="navbar-item" href="index.php?vista=home">
            <img src="img/logo.png" width="65" height="28" alt="Logo">
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    <i class="fas fa-users"></i><span class="nav-text">Usuarios</span>
                </a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=user_new" class="navbar-item">
                        <i class="fas fa-user-plus"></i><span class="nav-text">Nuevo</span>
                    </a>
                    <a href="index.php?vista=user_list" class="navbar-item">
                        <i class="fas fa-list"></i><span class="nav-text">Lista</span>
                    </a>
                    <a href="index.php?vista=user_search" class="navbar-item">
                        <i class="fas fa-search"></i><span class="nav-text">Buscar</span>
                    </a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    <i class="fas fa-list-ol"></i><span class="nav-text">Playlist</span>
                </a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=playlist_new" class="navbar-item">
                        <i class="fas fa-plus-circle"></i><span class="nav-text">Nueva Playlist</span>
                    </a>
                    <a href="index.php?vista=playlist_list" class="navbar-item">
                        <i class="fas fa-list"></i><span class="nav-text">Lista de Playlist</span>
                    </a>
                    <a href="index.php?vista=playlist_search" class="navbar-item">
                        <i class="fas fa-search"></i><span class="nav-text">Buscar Playlist</span>
                    </a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    <i class="fas fa-music"></i><span class="nav-text">Canciones</span>
                </a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=cancion_new" class="navbar-item">
                        <i class="fas fa-plus-circle"></i><span class="nav-text">Nueva Canción</span>
                    </a>
                    <a href="index.php?vista=cancion_list" class="navbar-item">
                        <i class="fas fa-list"></i><span class="nav-text">Lista de Canciones</span>
                    </a>
                    <a href="index.php?vista=cancion_playlist" class="navbar-item">
                        <i class="fas fa-headphones"></i><span class="nav-text">Canciones por Playlist</span>
                    </a>
                    <a href="index.php?vista=cancion_search" class="navbar-item">
                        <i class="fas fa-search"></i><span class="nav-text">Buscar Canciones</span>
                    </a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    <i class="fas fa-user-friends"></i><span class="nav-text">Artistas</span>
                </a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=artist_new" class="navbar-item">
                        <i class="fas fa-user-plus"></i><span class="nav-text">Nuevo Artista</span>
                    </a>
                    <a href="index.php?vista=artist_list" class="navbar-item">
                        <i class="fas fa-list"></i><span class="nav-text">Lista de Artistas</span>
                    </a>
                    <a href="index.php?vista=artist_search" class="navbar-item">
                        <i class="fas fa-search"></i><span class="nav-text">Canciones por Artista</span>
                    </a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    <i class="fas fa-compact-disc"></i><span class="nav-text">Álbumes</span>
                </a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=album_new" class="navbar-item">
                        <i class="fas fa-plus-circle"></i><span class="nav-text">Nuevo Álbum</span>
                    </a>
                    <a href="index.php?vista=album_list" class="navbar-item">
                        <i class="fas fa-list"></i><span class="nav-text">Lista de Álbumes</span>
                    </a>
                    <a href="index.php?vista=album_search" class="navbar-item">
                        <i class="fas fa-search"></i><span class="nav-text">Canciones por Álbum</span>
                    </a>
                </div>
            </div>

        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <a href="index.php?vista=play_history" class="button is-light is-rounded">
                    <i class="fas fa-history"></i><span class="nav-text">Historial</span>
                </a>
            </div>
            <div class="navbar-item">
                <div class="buttons">
                          <a href="index.php?vista=user_update&user_id_up=<?php echo isset($_SESSION['id'])?$_SESSION['id']:0; ?>" 
                       class="button is-primary is-rounded">
                        <i class="fas fa-user-circle"></i><span class="nav-text">Mi cuenta</span>
                    </a>

                          <a href="index.php?vista=logout" 
                       class="button is-danger is-rounded">
                        <i class="fas fa-sign-out-alt"></i><span class="nav-text">Salir</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- JavaScript para el menú hamburguesa -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const navbarBurgers = document.querySelectorAll('.navbar-burger');
    
    navbarBurgers.forEach(el => {
        el.addEventListener('click', () => {
            const target = el.dataset.target;
            const targetElement = document.getElementById(target);
            
            el.classList.toggle('is-active');
            targetElement.classList.toggle('is-active');
        });
    });
});
</script>