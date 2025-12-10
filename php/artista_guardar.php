<?php
# anotacion # Controlador para guardar artistas (crear)
# Entrada: POST: `artista_nombre`, `artista_biografia`, archivo `artista_foto` (opcional)
# Salida: HTML fragmento de notificacion para `FormularioAjax`

require_once __DIR__ . '/../inc/session_start.php';
require_once __DIR__ . '/../inc/main.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo error_alert('Metodo no permitido.');
    exit;
}

$nombre = isset($_POST['artista_nombre']) ? limpiar_cadena($_POST['artista_nombre']) : '';
$bio = isset($_POST['artista_biografia']) ? limpiar_cadena($_POST['artista_biografia']) : '';

if (empty($nombre)) {
    echo error_alert('El nombre del artista es obligatorio.');
    exit;
}

// obtener usuario logueado
$usuario_id = $_SESSION['id'] ?? 0;
if($usuario_id<=0){
    echo error_alert('Debe iniciar sesión para crear artistas.');
    exit;
}

$foto_ruta = '';
if (!empty($_FILES['artista_foto']['name'])) {
    $foto = $_FILES['artista_foto'];
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
    $dest = __DIR__ . '/../uploads/artista_fotos/' . $nuevo_nombre;
    if (!move_uploaded_file($foto['tmp_name'], $dest)) {
        echo error_alert('Error al subir la imagen.');
        exit;
    }
    $foto_ruta = 'uploads/artista_fotos/' . $nuevo_nombre;
}

try {
    $db = conexion();
    $sql = 'INSERT INTO artista (artista_nombre, artista_biografia, artista_foto, usuario_id) VALUES (:nombre, :bio, :foto, :usuario)';
    $stmt = $db->prepare($sql);
    $stmt->execute([':nombre' => $nombre, ':bio' => $bio, ':foto' => $foto_ruta, ':usuario' => $usuario_id]);
    echo success_alert('Artista creado correctamente.');
} catch (PDOException $e) {
    echo error_alert('Error en la base de datos: ' . $e->getMessage());
}

?>
