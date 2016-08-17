<?php

$section = "suscripcion";
require 'header.php';
if(SESION_INICIADA){
    header('location: mi_cuenta.php');
}
?>

<section class="titulo-seccion">
    <div class="titulo"><h1>Subcripción al servicio</h1></div>
</section>

<section class="formulario-subcripcion">
    <form id="form-suscripcion" method="post" action="javascript:enviarSuscripcion()" onsubmit="return validarSuscripcion()">
	<table>
	    <tr>
		<td class="etiqueta">Nombre</td>
		<td class="input"><input type="text" id="nombre" name="nombre" autofocus ><p class="error"></p></td>
	    </tr>
	    <tr>
		<td class="etiqueta">Apellidos</td>
		<td class="input"><input type="text" id="apellidos" name="apellidos" ><p class="error"></p></td>
	    </tr>
	    <tr>
		<td class="etiqueta">Nombre usuario</td>
		<td class="input"><input type="text" id="usuario" name="usuario" ><p class="error"></p></td>
	    </tr>
	    <tr>
		<td class="etiqueta">Contraseña</td>
		<td class="input"><input type="password" id="contrasenia" name="contrasenia" ><p class="error"></p></td>
	    </tr>
	    <tr>
		<td class="etiqueta">Verificar contraseña</td>
		<td class="input"><input type="password" id="contrasenia2" name="contrasenia2" ><p class="error"></p></td>
	    </tr>
	    <tr>
		<td class="etiqueta">Dirección</td>
		<td class="input"><input type="text" id="direccion" name="direccion" ><p class="error"></p></td>
	    </tr>
	    <tr>
		<td class="etiqueta">Ciudad</td>
		<td class="input"><input type="text" id="ciudad" name="ciudad" ><p class="error"></p></td>
	    </tr>
	    <tr>
		<td class="etiqueta">Provincia</td>
		<td class="input"><input type="text" id="provincia" name="provincia" ><p class="error"></p></td>
	    </tr>
	    <tr>
		<td class="etiqueta">Código postal</td>
		<td class="input"><input type="text" id="codigoPostal" name="codigoPostal" ><p class="error"></p></td>
	    </tr>
	    <tr>
		<td class="etiqueta">Email</td>
		<td class="input"><input type="email" id="email" name="email" ><p class="error"></p></td>
	    </tr>
	    <tr>
		<td class="etiqueta">DNI</td>
		<td class="input"><input type="text" id="dni" name="dni" ><p class="error"></p></td>
	    </tr>
	    <tr>
		<td class="etiqueta">VISA</td>
		<td class="input">
		    <input type="text" class="visa" id="visa1" name="visa1" maxlength="4" >
		    <input type="text" class="visa" id="visa2" name="visa2" maxlength="4" >
		    <input type="text" class="visa" id="visa3" name="visa3" maxlength="4" >
		    <input type="text" class="visa" id="visa4" name="visa4" maxlength="4" >
		    <p class="error"></p>
		</td>
	    </tr>
	    <tr>
		<td class="etiqueta">Observaciones</td>
		<td class="input"><textarea id="observaciones" name="observaciones"></textarea><p class="error"></p></td>
	    </tr>
	    <tr>
		<td class="etiqueta"></td>
		<td class="input">Envio:
		    <input type="radio" id="mensual" value="mensual" name="envio" checked><label for="mensual">Mensual</label>
		    <input type="radio" id="semanal" value="semanal" name="envio"><label for="semanal">Semanal</label>
		    <input type="radio" id="diario" value="diario" name="envio"><label for="diario">Diario</label>
		    <p class="error"></p>
		</td>
	    </tr>
	    <tr>
		<td class="etiqueta"></td>
		<td class="input"><input type="submit" id="btn-enviar" value="Enviar subcripción"><input type="checkbox" id="condiciones" name="condiciones" >He leído y acepto las condiciones del servicio de subcripción</td>
	    </tr>
	</table>
    </form>
</section>
<?php

require 'footer.php';
?>