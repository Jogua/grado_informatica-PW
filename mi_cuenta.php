<?php
$section = "mi_cuenta";
require 'header.php';
require_once 'script/Usuario.php';
if (!SESION_INICIADA) {
    header('location: suscripcion.php');
}
$usuario = Usuario::findById($_SESSION['idUsuario']);
if (!$usuario) {
    header('location: script/cerrar_sesion.php');
}
?>

<section class="titulo-seccion">
    <div class="titulo"><h1>Mi cuenta</h1></div>
</section>

<section class="mi-cuenta">
    <article class="datos-personales">
	<h3><?= $usuario->nombre ?> <?= $usuario->apellidos ?></h3>
	<p><?= $usuario->getDireccion() ?></p>
	<p>Usuario: <?= $usuario->usuario ?></p>
	<p>Email: <?= $usuario->email ?></p>
	<p>DNI: <?= $usuario->dni ?></p>
	<p>VISA: <?= $usuario->getVisa(); ?></p>
	<p>Observaciones:<br><?= $usuario->observaciones ?></p>
    </article>
</section>
<?php
require 'footer.php';
?>