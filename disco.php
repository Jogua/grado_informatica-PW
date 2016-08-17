<?php
$section = "disco";
require 'header.php';
require_once 'script/Disco.php';

if (!empty($_GET['d'])) {
    $disco = Disco::findById($_GET['d']);
    if ($disco == null) {
	header('location: index.php');
    }
} else {
    header('location: index.php');
}
?>

<section class="titulo-seccion">
    <img src="img/<?= $disco->getIconoGenero() ?>">
    <div class="titulo"><h1><a href="genero.php?g=<?= $disco->idGenero ?>"><?= $disco->getNombreGenero() ?></a></h1></div>
</section>

<?php require 'sidebar.php';?>

<div class="subcontainer">
    <section class="titulo-disco">
	<h1><?= $disco->nombre ?></h1>
    </section>
    <section class="lista-canciones">
	<?php
	$canciones = $disco->getCanciones();
	echo "<ul>";
	foreach ($canciones as $cancion):
	    echo "<li>$cancion->nombre</li>";
	endforeach;
	echo "</ul>";
	?>
    </section>

    <div class="wrapper card-dbl">
	<section class="disco">
	    <h1><?= $disco->artista ?></h1>
	    <img src="<?= $disco->portada ?>">
	    <p>Género: <?= $disco->getNombreGenero() ?></p>
	    <p>Precio: <?= $disco->precio ?> €</p>
	    <p>Producido: <?= $disco->productora ?></p>
	    <div class="valoracion">
		<p>Valoración</p>
		<ul class="ul-ranking">
		    <li class="current-rating" style="width:<?= $disco->getValoracion() * 7.5 ?>px;"></li>
		</ul>
	    </div>
	</section>
	<section class="canciones">
	    <form method="post" id="form-comprardisco" action="javascript:comprarDisco()">
		<input type="hidden" value="<?= $disco->id ?>" id="idDisco" name="idDisco"/>
		<table border = "1">
		    <?php
		    $i = 1;
		    foreach ($canciones as $cancion):
			$audio = "";
			if (!empty($cancion->musicaDemo)) {
			    $demo = $cancion->musicaDemo;
			    $audio = '<audio src="' . $demo . '" controls></audio>';
			}
			?>
    		    <tr>
    			<td><input type="checkbox" id="cancion<?= $i ?>" name="cancion<?= $i ?>"></td>
    			<td><label for="cancion<?= $i ?>"><?= $cancion->nombre ?></label></td>
    			<td><?= $audio ?></td>
    		    </tr>
			<?php
		    endforeach;
		    ?>
		</table>
		<div class = "opciones">
		    <button type="button"><?= $disco->getNumeroComentariosString() ?></button>
		    <input type="submit" value = "Comprar">
		</div>
	    </form>
	</section>
    </div>
    <section class="comentarios">
	<?php
	$comentarios = $disco->getComentarios();
	$yaComentado = false;
	foreach ($comentarios as $comentario) {
	    if (SESION_INICIADA && $_SESSION['idUsuario'] == $comentario->idUsuario) {
		$yaComentado = true;
	    }
	    ?>
    	<article class="comentario">
    	    <p class="identificacion"><strong><?= $comentario->getNombreUsuario() ?></strong> (<?= $comentario->getFecha() ?>)</p>
    	    <ul class="ul-ranking">
    		<li class="current-rating" style="width:<?= $comentario->getValoracion() * 7.5 ?>px;"></li>
    	    </ul>
    	    <p class="comment"><?= $comentario->getTexto() ?></p>
    	</article>
	    <?php
	}

	if (SESION_INICIADA && !$yaComentado) {
	    ?>
    	<form id="form-agregarcomentario" action="javascript:agregarComentario()" onsubmit="return validarComentario()">
    	    <input type="hidden" value="<?= $disco->id ?>" id="idDisco" name="idDisco"/>
    	    <div class="form-control">
    		<label for="comentario"><strong>Añade un comentario</strong></label><p class="error"></p><br>
    		<textarea id="comentario" name="comentario" maxlength="200"></textarea>
    		
    	    </div>
    	    <div class="form-control">
    		<label for="valoracion"><strong>Puntuación </strong></label>
		<input type="number" id="valoracion" name="valoracion" class="visa" min="0" max="10" value="10"/>
		<p class="error"></p>
    	    </div>
    	    <input type="submit" value="Comentar"/>
    	</form>
	    <?php
	} else if ($yaComentado) {
	    echo '<p id="mensajeiniciosesion">Ya has comentado en este disco.</p>';
	} else {
	    echo '<p id="mensajeiniciosesion" onclick="$(\'#form-iniciarSesion #usuario\').focus()">Para comentar inicia sesión.</p>';
	}
	?>
    </section>
</div>
<?php
require 'footer.php';
?>