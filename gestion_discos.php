<?php
$section = "gestion_discos";
require 'header.php';
include_once 'script/Disco.php';
if (!SESION_INICIADA || !IS_ADMIN) {
    header('location: index.php');
}
?>

<section class="titulo-seccion">
    <div class="titulo"><h1>Añadir disco</h1></div>
</section>

<section class="formulario-subcripcion">
    <form id="form-agregardisco" method="post" action="script/agregar_disco.php" enctype="multipart/form-data" onsubmit="return validarAgregarDisco()">
	<table>
	    <tbody>
		<tr>
		    <td class="etiqueta">Título</td>
		    <td class="input"><input type="text" id="titulo" name="titulo"><p class="error"></p></td>
		</tr>
		<tr>
		    <td class="etiqueta">Artista</td>
		    <td class="input">
			<input type="text" id="artista" name="artista" list="artistas">
			<datalist id="artistas"></datalist>
			<p class="error"></p>
		    </td>
		</tr>
		<tr>
		    <td class="etiqueta">Genero</td>
		    <td class="input">
			<select id="genero" name="genero">
			    <?php
			    $generos = Genero::getGeneros();
			    foreach ($generos as $genero):
				$id = $genero['id'];
				$nombre = $genero['nombre'];
				echo "<option value='$id'>$nombre</option>";
			    endforeach;
			    ?>
			</select>
			<p class="error"></p>
		    </td>
		</tr>
		<tr>
		    <td class="etiqueta">Productor</td>
		    <td class="input"><input type="text" id="productora" name="productora"><p class="error"></p></td>
		</tr>
		<tr>
		    <td class="etiqueta">Precio</td>
		    <td class="input"><input class="only-numbers" type="text" id="precio" name="precio"><p class="error"></p></td>
		</tr>
		<tr>
		    <td class="etiqueta">Portada</td>
		    <td class="input"><input type="file" id="portada" name="portada"><p class="error"></p></td>
		</tr>
		<tr class="cancion">
		    <td class="etiqueta">Canción 1</td>
		    <td class="input">
			Título <input type="text" id="tituloCancion1" name="tituloCanciones[]"><p class="error"></p><br>
			Música <input type="file" id="musicaCancion1" name="musicaCanciones[]"><br>
		    </td>
		</tr>
	    </tbody>
	    <tfoot>
		<tr>
		    <td></td><td><a class="btn" href="javascript:agregarCamposCanciones()">Añadir canción</a></td>
		</tr>
		<tr>
		    <td class="etiqueta"></td>
		    <td class="input"><input type="submit" id="btn-enviar" value="Añadir disco"></td>
		</tr>
	    </tfoot>
	</table>
    </form>
</section>
<?php
require 'footer.php';
?>