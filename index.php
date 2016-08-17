<?php
$section = "index";
require 'header.php';
require 'sidebar.php';
?>

<div class="subcontainer">
    <section class="card card-left noticias">
	<h3>Noticias musicales</h3>
	<ul>
	    <a href="#noticias"><li>Noticia 1</li></a>
	    <a href="#noticias"><li>Noticia 2</li></a>
	    <a href="#noticias"><li>Noticia 3</li></a>
	    <a href="#noticias"><li>Noticia 4</li></a>
	    <a href="#noticias"><li>Noticia 5</li></a>
	    <a href="#noticias"><li>Noticia 6</li></a>
	    <a href="#noticias"><li>Noticia 7</li></a>
	    <a href="#noticias"><li>Noticia 8</li></a>
	    <a href="#noticias"><li>Noticia 9</li></a>
	    <a href="#noticias"><li>Noticia 10</li></a>
	</ul>
    </section>

    <section class="card card-right mas-comentado ocultarMoviles">
	<h3>Disco más comentado</h3>
	<article>
	    <img src="img/malu_caos/disco.jpeg">
	    <div class="datos">
		<h2>Caos</h2>
		<h3>Malú</h3>
		<button><a href="disco.php?d=2">15 comentarios</a></button>
	    </div>
	    <audio id="disco2" src="music/muestra_piano.mp3" controls></audio>
	</article>
    </section>

    <section class="card card-left mas-comentado">
	<h3>Disco destacado</h3>
	<article>
	    <img src="img/jennifer_lopez_ain't_your_mama/disco.jpeg">
	    <div class="datos">
		<h2>Ain't your mama</h2>
		<h3>Jennifer López</h3>
		<button><a href="disco.php?d=1">10 comentarios</a></button>
	    </div>
	    <audio id="disco2" src="music/muestra_piano.mp3" controls></audio>
	</article>
    </section>

    <section class="card card-right mas-comentado ocultarMoviles">
	<h3>Disco más comentado</h3>
	<article>
	    <img src="img/chris_lane_fix/disco.jpeg">
	    <div class="datos">
		<h2>Fix</h2>
		<h3>Chris Lane</h3>
		<button><a href="disco.php?d=6">13 comentarios</a></button>
	    </div>
	    <audio id="disco2" src="music/muestra_piano.mp3" controls></audio>
	</article>
    </section>

    <section class="ultimos-discos">
	<h3>Últimos discos por género</h3>
	<button><a href="genero.php?g=1"> ROCK </a></button>
	<button><a href="genero.php?g=2"> POP </a></button>
	<button><a href="genero.php?g=3"> COUNTRY </a></button>
	<section class="ultimas-novedades">
	    <article>
		<img src="img/la_ley_adaptacion/disco.jpeg">
		<div class="datos">
		    <h2>Adaptación</h2>
		    <h3>La Ley</h3>
		</div>
		<div class="botones">
		    <audio id="disco1" src="music/muestra_piano.mp3" controls></audio>
		    <button><a href="disco.php?d=3">No hay comentarios</a></button>
		</div>
	    </article>
	    <article>
		<img src="img/babasonicos_vampi/disco.jpeg">
		<div class="datos">
		    <h2>Vampi</h2>
		    <h3>Babasónicos</h3>
		</div>
		<div class="botones">
		    <audio id="disco1" src="music/muestra_piano.mp3" controls></audio>
		    <button><a href="disco.php?d=4">3 comentarios</a></button>
		</div>
	    </article>
	    <article>
		<img src="img/disco.png">
		<div class="datos">
		    <h2>Titulo</h2>
		    <h3>Artista</h3>
		</div>
		<div class="botones">
		    <audio id="disco1" src="music/muestra_piano.mp3" controls></audio>
		    <button><a href="#disco1">12 comentarios</a></button>
		</div>
	    </article>
	</section>
    </section>
</div>

<?php
require 'footer.php';
?>