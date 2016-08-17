<?php

require_once 'Usuario.php';

if (count($_POST) == 2) {
    $contrasenia = $_POST['contrasenia'];
    $usuario = Usuario::findByUsername($_POST['usuario']);
    if($usuario){
	if (md5($contrasenia) == $usuario->contrasenia){
	    session_start();
	    $_SESSION['idUsuario'] = $usuario->id;
	    $_SESSION['usuario'] = $usuario->usuario;
	    $_SESSION['rol'] = $usuario->rol;
	    echo "true";
	    die();
	}
    }
}
echo "false";
?>