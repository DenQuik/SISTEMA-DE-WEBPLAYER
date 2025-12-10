<?php
# anotacion # Controlador para guardar albums (crear)
# Entrada: POST: `album_titulo`, `album_year`, `artista_id`, archivo `album_portada` (opcional)
# Salida: HTML fragmento de notificacion para `FormularioAjax`

require_once __DIR__ . '/../inc/session_start.php';
require_once __DIR__ . '/../inc/main.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo error_alert('Metodo no permitido.');
    exit;
}

$titulo = isset($_POST['album_titulo']) ? limpiar_cadena($_POST['album_titulo']) : '';
$year = isset($_POST['album_year']) ? (int) $_POST['album_year'] : 0;
$artista = isset($_POST['artista_id']) ? (int) $_POST['artista_id'] : 0;

if (empty($titulo) || $artista<=0 || $year<=0) {
    echo error_alert('Faltan datos obligatorios.');
    exit;
}

$foto_ruta = '';
if (!empty($_FILES['album_portada']['name'])) {
    $foto = $_FILES['album_portada'];
    $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','gif'];
    if (!in_array(strtolower($ext), $allowed)) {
        echo error_alert('Formato de imagen no permitido.');
        exit;
    }
    if ($foto['size'] > 2 * 1024 * 1024) {
        echo error_alert('La imagen excede 2MB.');
        exit;
    }
    $nuevo_nombre = renombrar_fotos($foto['name']);
    $dest = __DIR__ . '/../uploads/album_portadas/' . $nuevo_nombre;
    if (!move_uploaded_file($foto['tmp_name'], $dest)) {
        echo error_alert('Error al subir la imagen.');
        exit;
    }
    $foto_ruta = 'uploads/album_portadas/' . $nuevo_nombre;
}

try {
    $db = conexion();
    $sql = 'INSERT INTO album (album_titulo, album_portada, album_year, artista_id, usuario_id) VALUES (:titulo, :foto, :year, :artista, :usuario)';
    $stmt = $db->prepare($sql);
    $usuario_id = $_SESSION['id'] ?? 0;
    if($usuario_id<=0){
        echo error_alert('Debe iniciar sesión para crear albums.');
        exit;
    }
    $stmt->execute([':titulo' => $titulo, ':foto' => $foto_ruta, ':year' => $year, ':artista' => $artista, ':usuario' => $usuario_id]);
    echo success_alert('Album creado correctamente.');
} catch (PDOException $e) {
    echo error_alert('Error en la base de datos: ' . $e->getMessage());
}

?>
