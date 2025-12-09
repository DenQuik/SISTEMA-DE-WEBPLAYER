<div class="container is-fluid">
	<h1>­</h1>
	<h1 class="title">Home</h1>
	<h2 class="subtitle">¡Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>!</h2>
</div>

<?php
// Mostrar las últimas canciones (proxy de "reproducidas" usando cancion_id desc)
require_once __DIR__ . '/../inc/main.php';
$db = conexion();
$ultimas = $db->query("SELECT c.cancion_id, c.cancion_titulo, a.artista_nombre FROM cancion c LEFT JOIN artista a ON c.artista_id=a.artista_id ORDER BY c.cancion_id DESC LIMIT 6");
$ultimas = $ultimas->fetchAll();
$db = null;
?>
<div class="container pb-6 pt-6">
	<h2 class="title is-5">Últimas canciones</h2>
	<div class="box">
		<?php if(count($ultimas)>0): ?>
			<ul>
				<?php foreach($ultimas as $s): ?>
					<li style="margin-bottom:8px;">
						<?php echo htmlspecialchars($s['cancion_titulo']); ?>
						<?php if(!empty($s['artista_nombre'])): ?>
							<small class="has-text-grey"> — <?php echo htmlspecialchars($s['artista_nombre']); ?></small>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p>No hay canciones registradas aún.</p>
		<?php endif; ?>
	</div>
</div>