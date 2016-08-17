<?php
require_once 'script/Genero.php';
require_once 'script/Disco.php';
session_start();
if (!empty($_SESSION['usuario'])) {
    define("SESION_INICIADA", true);
    if ($_SESSION['rol'] == 'admin') {
	define("IS_ADMIN", true);
    } else {
	define("IS_ADMIN", false);
    }
} else {
    define("SESION_INICIADA", false);
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
	<title>SolFa Music</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="icon" type="image/png" href="favicon.png" />
    </head>
    <body>
	<header>
	    <a href="index.php">
		<img src="img/logo.png">
		<div class="titulo"><h1>SolFa Music</h1></div>
	    </a>
	    <div class="login">
		<?php
		if (SESION_INICIADA) {
		    echo "<span>Sesión iniciada como: <strong>" . $_SESSION['usuario'] . "</strong></span><a href='script/cerrar_sesion.php'>Cerrar sesión</a>";
		} else {
		    ?>
    		<form id="form-iniciarSesion" action="javascript:iniciarSesion()">
    		    <input type="text" placeholder="usuario" id="usuario" name="usuario" required>
    		    <input type="password" placeholder="contrasenia" id="contrasenia" name="contrasenia" required>
    		    <input type="submit" value="Entrar">
    		</form>
		    <?php
		}
		?>
	    </div>
	</header>

	<aside id="publi" class="publicidad"></aside>

	<div class="main-container">
	    <?php if ($section == 'index') {
		$disco = Disco::findById(3);
		?>
    	    <section class="ultimas-novedades">
    		<a href="disco.php?d=<?=$disco->id?>">
    		    <article>
    			<img src="<?=$disco->portada?>">
    			<div class="datos">
    			    <h2><?=$disco->nombre?></h2>
    			    <h3><?=$disco->artista?></h3>
    			</div>
    			<div class="botones">
			    <audio id="disco1" src="<?=$disco->getDemo()?>" controls></audio>
			    <button><?=$disco->getNumeroComentariosString()?></button>
    			</div>
    		    </article>
    		</a>
		<?php
		$disco = Disco::findById(1);
		?>
    		<a href="disco.php?d=<?=$disco->id?>" class="ocultarMoviles">
    		    <article>
    			<img src="<?=$disco->portada?>">
    			<div class="datos">
    			    <h2><?=$disco->nombre?></h2>
    			    <h3><?=$disco->artista?></h3>
    			</div>
    			<div class="botones">
			    <audio id="disco1" src="<?=$disco->getDemo()?>" controls></audio>
			    <button><?=$disco->getNumeroComentariosString()?></button>
    			</div>
    		    </article>
    		</a>
		<?php
		$disco = Disco::findById(5);
		?>
    		<a href="disco.php?d=<?=$disco->id?>" class="ocultarMoviles">
    		    <article>
    			<img src="<?=$disco->portada?>">
    			<div class="datos">
    			    <h2><?=$disco->nombre?></h2>
    			    <h3><?=$disco->artista?></h3>
    			</div>
    			<div class="botones">
			    <audio id="disco1" src="<?=$disco->getDemo()?>" controls></audio>
			    <button><?=$disco->getNumeroComentariosString()?></button>
    			</div>
    		    </article>
    		</a>
    	    </section>
		<?php }
	    ?>
	    <nav class="main-menu">
		<ul id="navlist">
		    <li><a href="index.php">Inicio</a></li>
		    <li><a>Géneros</a>
			<ul>
			    <?php
			    $generos = Genero::getGeneros();
			    foreach ($generos as $genero):
				$id = $genero['id'];
				$nombre = $genero['nombre'];
				echo "<li><a href='genero.php?g=$id'>$nombre</a></li>";
			    endforeach;
			    ?>
			</ul>
		    </li>	
		    <li><a href="mas_vendidos.php">Más vendidos</a></li>
		    <li><a href="mas_comentados.php">Más comentados</a></li>
		    <?php
		    if (SESION_INICIADA) {
			echo '<li><a href="mi_cuenta.php">Mi Cuenta</a></li>';
			if (IS_ADMIN) {
			    echo '<li><a href="gestion_discos.php">Gestionar discos</a></li>';
			}
		    } else {
			echo '<li><a href="suscripcion.php">Suscripción</a></li>';
		    }
		    ?>
		</ul>
	    </nav>