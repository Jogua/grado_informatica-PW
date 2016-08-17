<?php

require_once 'Disco.php';

$resultado = [];
if (!empty($_POST['nombre'])) {
    $artistas = Disco::getArtistas($_POST['nombre']);
    if ($artistas) {
	foreach ($artistas as $key => $value) {
	    if($key == "artista"){
		array_push($resultado, $value);
	    }
	}
	$resultado = $artistas;
    }
}
echo json_encode($resultado);
die();
?>