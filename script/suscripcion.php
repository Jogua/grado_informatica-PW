<?php

require_once 'Usuario.php';

if (count($_POST) == 18) {
    $params = $_POST;
    $params['id']  = null;
    $params['rol']  = 'user';
    $params['visa'] = $params['visa1'] .'-'. $params['visa2'] .'-'. $params['visa3'] .'-'. $params['visa4'];
    $params['dni'] = strtoupper($params['dni']);
    $params['contrasenia'] = md5($params['contrasenia']);
    $usuario = new Usuario($params);
    if($usuario->guardar()){
	session_start();
	$_SESSION['idUsuario'] = $usuario->id;
	$_SESSION['usuario'] = $usuario->usuario;
	$_SESSION['rol'] = $usuario->rol;
	echo "true";
	die();
    }
}
echo "false";
?>