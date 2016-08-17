<?php

require_once 'Disco.php';
session_start();
if (isset($_SESSION['idUsuario'])) {
    $idUsuario = $_SESSION['idUsuario'];
} else {
    echo "iniciaSesion";
    die();
}

if (!empty($_POST['idDisco'])) {
    $disco = Disco::findById($_POST['idDisco']);
    if ($disco) {
	$exito = $disco->comprar($idUsuario);
	if($exito){
	    echo "true";
	    die();
	}
    }
}
echo "false";
?>