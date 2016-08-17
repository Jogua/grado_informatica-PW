<?php

require_once 'Disco.php';

$exito = false;
if (count($_POST) == 6) {
    $nombreCarpeta = str_replace(" ", "_", normaliza($_POST['artista'] . "_" . $_POST['titulo']));
    $nombrePortada = guardarImagen('portada', $nombreCarpeta, 'disco');
    if ($nombrePortada) {
	$disco = new Disco();
	$disco->id = null;
	$disco->nombre = $_POST['titulo'];
	$disco->artista = $_POST['artista'];
	$disco->precio = $_POST['precio'];
	$disco->productora = $_POST['productora'];
	$disco->idGenero = $_POST['genero'];
	$disco->portada = $nombrePortada;
	if ($disco->guardar()) {
	    for ($i = 0; $i < count($_POST['tituloCanciones']); $i++) {
		$titulo = $_POST['tituloCanciones'][$i];
		$nombre_fichero = guardarMusica($i, $nombreCarpeta, $titulo);
		$disco->addCancion($titulo, $nombre_fichero);
	    }
	    $exito = true;
	    echo "<script>alert('El disco se ha agregado correctamente'); location.href='../genero.php?g=$disco->idGenero'</script>";
	}
    }
}
if (!exito) {
    echo "<script>alert('Ha ocurrido un error'); location.href='" . $_SERVER['HTTP_REFERER'] . "'</script>";
}

function guardarImagen($id, $nombreCarpeta, $nombreFichero) {
    if ($_FILES[$id]["error"] == 0) {
	$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
	$limite_kb = 2048; //2M
	if (in_array($_FILES[$id]['type'], $permitidos) && $_FILES[$id]['size'] <= $limite_kb * 1024) {
	    $nombreFichero = normaliza($nombreFichero) . "." . explode("/", $_FILES[$id]['type'])[1];
	    $carpeta = "../img/" . $nombreCarpeta;
	    if (!is_dir($carpeta)) {
		mkdir($carpeta);
	    }
	    $ruta = $carpeta . "/" . $nombreFichero;
	    if (!file_exists($ruta)) {
		$resultadoSubida = @move_uploaded_file($_FILES[$id]['tmp_name'], $ruta);
		if ($resultadoSubida) {
		    return "img/" . $nombreCarpeta . "/" . $nombreFichero;
		}
	    }
	}
    }
    return null;
}

function guardarMusica($id, $nombreCarpeta, $nombreFichero) {
    if ($_FILES["musicaCanciones"]["error"][$id] == 0) {
	$permitidos = array("audio/mpeg3", "audio/x-mpeg-3", "audio/mpeg", "audio/mp3");
	$limite_kb = 8192; //8M
	if (in_array($_FILES["musicaCanciones"]['type'][$id], $permitidos) && $_FILES["musicaCanciones"]['size'][$id] <= $limite_kb * 1024) {
	    $nombreFichero = normaliza($nombreFichero) . ".mp3";
	    $carpeta = "../music/" . $nombreCarpeta;
	    if (!is_dir($carpeta)) {
		mkdir($carpeta);
	    }
	    $ruta = $carpeta . "/" . $nombreFichero;
	    if (!file_exists($ruta)) {
		$resultadoSubida = @move_uploaded_file($_FILES["musicaCanciones"]['tmp_name'][$id], $ruta);
		if ($resultadoSubida) {
		    return "music/" . $nombreCarpeta . "/" . $nombreFichero;
		}
	    }
	}
    }
    return null;
}

function normaliza($cadena) {
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ ';
    $reemplazar = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr_';
    $cadena = utf8_decode(trim($cadena));
    $cadena = strtr($cadena, utf8_decode($originales), $reemplazar);
    $cadena = strtolower($cadena);
    return utf8_encode($cadena);
}

?>