<?php
$section = "genero";
require 'header.php';
require_once 'script/Genero.php';
require_once 'script/Disco.php';
if (!empty($_GET['g'])) {
    $genero = Genero::findById($_GET['g']);
    if ($genero == null) {
	header('location: index.php');
    }
} else {
    header('location: index.php');
}
$discos = Disco::findByIdGenero($genero->id);
?>

<section class="titulo-seccion">
    <img src="img/<?= $genero->icono ?>">
    <div class="titulo"><h1><?= $genero->nombre ?></h1></div>
</section>

<?php require 'sidebar.php';?>

<div class="subcontainer">
    <?php
    if (count($discos) == 0) {
	echo "<p>No hay discos en este género</p>";
    } else {
	?>
        <section class="card card-left card-dbl destacado">
    	<h3>Disco destacado</h3>
    	<article>
    	    <img src="<?= $discos[0]->portada ?>">
    	    <div class="datos">
    		<h2><?= $discos[0]->nombre ?></h2>
    		<h3><?= $discos[0]->artista ?></h3>
    		<audio src="<?= $discos[0]->getDemo() ?>" controls></audio>
    	    </div>
    	    <div class="ver-mas">
    		<a href="disco.php?d=<?= $discos[0]->id ?>">Ver</a>
    		<button><a href="disco.php?d=<?= $discos[0]->id ?>"><?=$discos[0]->getNumeroComentariosString()?></a></button>
    	    </div>
    	</article>
        </section>

	<?php
	for ($i = 1; $i < count($discos); $i++) {
	    $disco = $discos[$i];
	    if ($i % 2 == 1) { //Izquierda
		echo '<section class="card card-left mas-comentado">';
	    } else { //Derecha
		echo '<section class="card card-right mas-comentado">';
	    }
	    ?>
	    <article>
		<img src="<?= $disco->portada ?>">
		<div class="datos">
		    <h2><?= $disco->nombre ?></h2>
		    <h3><?= $disco->artista ?></h3>
		    <button><a href="disco.php?d=<?= $disco->id ?>"><?= $disco->getNumeroComentariosString() ?></a></button>
		</div>
		<audio src="<?= $disco->getDemo() ?>" controls></audio>
	    </article>
	    <?php
	    echo '</section>';
	}
    }
    ?>
</div>
<?php
require 'footer.php';
?>