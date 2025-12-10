<?php
# Archivo: cancion_lista.php
# Propósito: Genera la lista paginada de canciones para la vista administrativa
# Entrada: parámetros de paginación por GET (ej. $pagina, $registros, $busqueda)
# Salida: HTML con la tabla/lista de canciones
# Realiza dos consultas: una para los datos y otra para el total (paginación) #
    $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
    $tabla = "";

    if(isset($busqueda) && $busqueda!=""){
        $consulta_datos = "SELECT c.*, a.artista_nombre, g.genero_nombre, al.album_titulo FROM cancion c LEFT JOIN artista a ON c.artista_id=a.artista_id LEFT JOIN genero g ON c.genero_id=g.genero_id LEFT JOIN album al ON c.album_id=al.album_id WHERE (c.cancion_titulo LIKE '%$busqueda%' OR a.artista_nombre LIKE '%$busqueda%') ORDER BY c.cancion_titulo ASC LIMIT $inicio,$registros";
        $consulta_total = "SELECT COUNT(cancion_id) FROM cancion WHERE (cancion_titulo LIKE '%$busqueda%')";
    }else{
        $consulta_datos = "SELECT c.*, a.artista_nombre, g.genero_nombre, al.album_titulo FROM cancion c LEFT JOIN artista a ON c.artista_id=a.artista_id LEFT JOIN genero g ON c.genero_id=g.genero_id LEFT JOIN album al ON c.album_id=al.album_id ORDER BY c.cancion_titulo ASC LIMIT $inicio,$registros";
        $consulta_total = "SELECT COUNT(cancion_id) FROM cancion";
    }

    $conexion = conexion();
    $datos = $conexion->query($consulta_datos);
    $datos = $datos->fetchAll();

    $total = $conexion->query($consulta_total);
    $total = (int) $total->fetchColumn();

    $Npaginas = ceil($total / $registros);

    $tabla .= '<div class="table-container">'
    . '<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">'
    . '<thead><tr class="has-text-centered"><th>#</th><th>Titulo</th><th>Artista</th><th>Genero</th><th>Album</th><th>Archivo</th><th>Opciones</th></tr></thead><tbody>';

    if($total>=1 && $pagina<=$Npaginas){
        $contador = $inicio + 1;
        $pag_inicio = $inicio + 1;
        foreach($datos as $rows){
            if($rows['cancion_archivo']!=""){
                $archivoLink = '<audio controls src="'. htmlspecialchars($rows['cancion_archivo'], ENT_QUOTES) .'" preload="none"></audio>';
            }else{
                $archivoLink = '-';
            }
            $tabla .= '<tr class="has-text-centered"><td>'.$contador.'</td><td>'.$rows['cancion_titulo'].'</td><td>'.$rows['artista_nombre'].'</td><td>'.$rows['genero_nombre'].'</td><td>'.$rows['album_titulo'].'</td><td>'.$archivoLink.'</td><td><a href="index.php?vista=cancion_update&cancion_id_up='.$rows['cancion_id'].'" class="button is-success is-rounded is-small">Actualizar</a> <a href="'.$url.$pagina.'&cancion_id_del='.$rows['cancion_id'].'" class="button is-danger is-rounded is-small" onclick="return confirm(\'¿Desea eliminar la canción seleccionada?\');">Eliminar</a></td></tr>';
            $contador++;
        }
        $pag_final = $contador - 1;
    }else{
        if($total>=1){
            $tabla .= '<tr class="has-text-centered"><td colspan="7"><a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">Haga clic acá para recargar el listado</a></td></tr>';
        }else{
            $tabla .= '<tr class="has-text-centered"><td colspan="7">No hay registros en el sistema</td></tr>';
        }
    }

    $tabla .= '</tbody></table></div>';

    if($total>0 && $pagina<=$Npaginas){
        $tabla .= '<p class="has-text-right">Mostrando canciones <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
    }

    $conexion = null;
    echo $tabla;

    if($total>=1 && $pagina<=$Npaginas){
        echo paginador_tablas($pagina,$Npaginas,$url,7);
    }

?>
