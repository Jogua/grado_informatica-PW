<?php

require_once 'Disco.php';
session_start();
if (isset($_SESSION['idUsuario'])) {
    $idUsuario = $_SESSION['idUsuario'];
} else {
    header('location: ../suscripcion.php');
}

if (count($_POST) == 3) {
    $disco = Disco::findById($_POST['idDisco']);
    if ($disco) {
	$exito = $disco->addComentario($idUsuario, $_POST['comentario'], $_POST['valoracion']);
	if($exito){
	    echo "true";
	    die();
	}
    }
}
echo "false";
?>