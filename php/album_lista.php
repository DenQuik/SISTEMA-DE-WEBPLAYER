<?php
# Archivo: album_lista.php
# Propósito: Lista paginada de albums para el panel
require_once __DIR__ . '/../inc/main.php';

$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
$tabla = "";

if(isset($busqueda) && $busqueda!=""){
    $consulta_datos = "SELECT al.*, ar.artista_nombre FROM album al LEFT JOIN artista ar ON al.artista_id=ar.artista_id WHERE al.album_titulo LIKE '%$busqueda%' ORDER BY al.album_titulo ASC LIMIT $inicio,$registros";
    $consulta_total = "SELECT COUNT(album_id) FROM album WHERE album_titulo LIKE '%$busqueda%'";
}else{
    $consulta_datos = "SELECT al.*, ar.artista_nombre FROM album al LEFT JOIN artista ar ON al.artista_id=ar.artista_id ORDER BY al.album_titulo ASC LIMIT $inicio,$registros";
    $consulta_total = "SELECT COUNT(album_id) FROM album";
}

$conexion = conexion();
$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();

$total = $conexion->query($consulta_total);
$total = (int) $total->fetchColumn();

$Npaginas = ceil($total / $registros);

$tabla .= '<div class="table-container">'
    . '<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">'
    . '<thead><tr class="has-text-centered"><th>#</th><th>Titulo</th><th>Año</th><th>Artista</th><th>Portada</th><th>Opciones</th></tr></thead><tbody>';

if($total>=1 && $pagina<=$Npaginas){
    $contador = $inicio + 1;
    $pag_inicio = $inicio + 1;
    foreach($datos as $rows){
        $portada = $rows['album_portada']!="" ? '<img src="'.htmlspecialchars($rows['album_portada'], ENT_QUOTES).'" width="60">' : '-';
        $tabla .= '<tr class="has-text-centered"><td>'.$contador.'</td><td>'.$rows['album_titulo'].'</td><td>'.$rows['album_year'].'</td><td>'.$rows['artista_nombre'].'</td><td>'.$portada.'</td><td><a href="index.php?vista=album_update&album_id_up='.$rows['album_id'].'" class="button is-success is-rounded is-small">Actualizar</a> <a href="'.$url.$pagina.'&album_id_del='.$rows['album_id'].'" class="button is-danger is-rounded is-small" onclick="return confirm(\'¿Desea eliminar el album seleccionado?\');">Eliminar</a></td></tr>';
        $contador++;
    }
    $pag_final = $contador - 1;
}else{
    if($total>=1){
        $tabla .= '<tr class="has-text-centered"><td colspan="6"><a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">Haga clic acá para recargar el listado</a></td></tr>';
    }else{
        $tabla .= '<tr class="has-text-centered"><td colspan="6">No hay registros en el sistema</td></tr>';
    }
}

$tabla .= '</tbody></table></div>';

if($total>0 && $pagina<=$Npaginas){
    $tabla .= '<p class="has-text-right">Mostrando albums <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
}

$conexion = null;
echo $tabla;

if($total>=1 && $pagina<=$Npaginas){
    echo paginador_tablas($pagina,$Npaginas,$url,7);
}

?>
