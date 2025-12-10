# Sistema WebPlayer

Documentación del proyecto "SISTEMA-DE-WEBPLAYER" — un sistema adaptado para servir como reproductor web y manager básico de música.

Nota: este README está escrito en español y cubre la estructura del código, instalación local, endpoints principales y recomendaciones de seguridad.

## Resumen
- Tecnología: PHP (PDO), MySQL/MariaDB, Bulma CSS, JavaScript (AJAX)
- Arquitectura: Front controller `index.php?vista=...`, vistas en `vistas/`, controladores en `php/`, includes en `inc/`.
- Base de datos: dump en `db/webplayer.sql` (tablas: `usuario`, `cancion`, `artista`, `album`, `genero`, `playlist`, `playlist_cancion`, etc.)

## Requisitos
- XAMPP (Apache + PHP + MySQL/MariaDB) en Windows o entorno equivalente
- PHP 7.4+ / 8.x (el código usa PDO)

## Instalación rápida (local)
1. Copia el proyecto dentro de tu carpeta web (ej. `C:\xampp\htdocs\nigger`).
2. Importa la base de datos desde `db/webplayer.sql` usando phpMyAdmin o CLI:

```powershell
# Desde PowerShell (ejemplo):
mysql -u root -p < db\webplayer.sql
```

3. Inicia Apache y MySQL desde XAMPP.
4. Abre en navegador: `http://localhost/nigger/index.php`.

Usuario administrador por defecto (según volcado):
- `usuario_usuario`: `Administrador` (puedes cambiar su contraseña/usuario en la tabla `usuario`).

## Estructura principal de carpetas
- `index.php` - controlador frontal que carga vistas según `?vista=`.
- `inc/` - includes y helpers
  - `main.php` - funciones auxiliares: `conexion()`, validaciones, `renombrar_fotos()`, paginador y helpers `success_alert()` / `error_alert()`.
  - `session_start.php` - inicia sesión con `session_name('INV')`.
  - `navbar.php`, `head.php`, `script.php` - layout y enlaces.
- `php/` - controladores que procesan formularios y acciones (deben devolver fragmentos HTML compatibles con `FormularioAjax`).
- `vistas/` - vistas cargadas por `index.php?vista=...` (formularios y listados).
- `uploads/` - subcarpetas para almacenar archivos subidos (`canciones`, `cancion_portadas`, `artista_fotos`, `album_portadas`, `playlist_portadas`, etc.)
- `db/webplayer.sql` - volcado de la base de datos.

## Módulos implementados

1. Canciones
   - Vistas: `vistas/cancion_new.php`, `vistas/cancion_list.php`, `vistas/cancion_update.php`, `vistas/cancion_playlist.php`.
   - Controladores: `php/cancion_guardar.php`, `php/cancion_actualizar.php`, `php/cancion_eliminar.php`, `php/cancion_lista.php`.
   - Archivos: audio en `uploads/canciones/`, portadas en `uploads/cancion_portadas/`.

2. Artistas
   - Vistas: `vistas/artist_new.php`, `vistas/artist_list.php`, `vistas/artist_update.php`, `vistas/artist_search.php`.
   - Controladores: `php/artista_guardar.php`, `php/artista_lista.php`, `php/artista_actualizar.php`, `php/artista_eliminar.php`.
   - Archivos: fotos en `uploads/artista_fotos/`.

3. Álbumes
   - Vistas: `vistas/album_new.php`, `vistas/album_list.php`, `vistas/album_update.php`, `vistas/album_search.php`.
   - Controladores: `php/album_guardar.php`, `php/album_lista.php`, `php/album_actualizar.php`, `php/album_eliminar.php`.
   - Archivos: portadas en `uploads/album_portadas/`.

4. Playlists
   - Vistas: `vistas/playlist_new.php`, `vistas/playlist_list.php`, `vistas/playlist_update.php`, `vistas/playlist_search.php`.
   - Controladores: `php/playlist_guardar.php`, `php/playlist_actualizar.php`, `php/playlist_eliminar.php`, `php/playlist_cancion_guardar.php`, `php/playlist_cancion_eliminar.php`.

5. Géneros (nuevo módulo añadido)
   - Vistas: `vistas/genero_new.php`, `vistas/genero_list.php`, `vistas/genero_update.php`, `vistas/genero_search.php`.
   - Controladores: `php/genero_guardar.php`, `php/genero_lista.php`, `php/genero_actualizar.php`, `php/genero_eliminar.php`.

6. Usuarios
   - Vistas y controladores existentes (`vistas/user_*`, `php/usuario_*`) para registro, login, actualización y listado.

7. Historial de reproducciones
   - Vista: `vistas/play_history.php` (si existe tabla `play_history` muestra el historial, si no, muestra últimas canciones como fallback).

## Patrón AJAX y respuestas
- El proyecto usa `js/ajax.js` y la clase `FormularioAjax` para enviar formularios; los controladores deben devolver fragmentos HTML (notificaciones) que se inyectan en `.form-rest`.
- Para consistencia, use `success_alert($msg)` y `error_alert($msg)` desde `inc/main.php` para responder.

## Rutas principales (vistas)
- `index.php?vista=home` — Home / últimas canciones
- `index.php?vista=cancion_new` — Subir nueva canción
- `index.php?vista=cancion_list` — Listado de canciones
- `index.php?vista=artist_new` — Crear artista
- `index.php?vista=artist_list` — Listado de artistas
- `index.php?vista=album_new` — Crear álbum
- `index.php?vista=album_list` — Listado de álbumes
- `index.php?vista=playlist_new` — Crear playlist
- `index.php?vista=playlist_list` — Listado de playlists
- `index.php?vista=genero_new` — Crear género
- `index.php?vista=genero_list` — Lista de géneros
- `index.php?vista=genero_search` — Buscar canciones por género
- `index.php?vista=play_history` — Historial de reproducciones

## Seguridad y recomendaciones
- Protege la carpeta `uploads/` para evitar ejecución de scripts. Ejemplo `.htaccess` para Apache en cada carpeta de `uploads/`:

```apache
# Evitar ejecución de scripts
<FilesMatch "\.(php|phtml|php5|phar)$">
  Require all denied
</FilesMatch>

# Permitir sólo archivos estáticos
Options -ExecCGI
```

- Valida y sanea todos los datos en servidores (ya usamos `limpiar_cadena()` y prepared statements para queries).
- Considera añadir CSRF tokens a los formularios si expones el sistema públicamente.
- Usa HTTPS en producción.

## Notas de desarrollo y próximos pasos sugeridos
- Mejorar manejo de roles/permiso (el flujo actual usa `$_SESSION['id']` y un `admin` duro con id==1 en algunos checks).
- Añadir endpoint para registrar reproducciones en `play_history` desde el reproductor (JS) si quieres historial real por usuario.
- Añadir protección de uploads y límites más estrictos según tus necesidades.

Si quieres, puedo:
- Agregar `.htaccess` automáticamente a las carpetas `uploads/`.
- Crear el endpoint de logging de reproducciones y el llamado JS desde el reproductor.
- Añadir control de roles/permisos más completo.

Indícame cuál de esas tareas quieres que haga a continuación.
