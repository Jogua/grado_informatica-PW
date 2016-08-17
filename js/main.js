$(".only-numbers").keypress(function (e) {
    var teclaPulsada = window.event ? window.event.keyCode : e.which;
    var esDecimal = this.value.indexOf(".") !== -1;
    if (!esDecimal) {
	if (teclaPulsada === 46) { //Tecla 46 = "."
	    return true;
	} else if (teclaPulsada === 44) { //Tecla 44 = ",")
	    this.value = this.value + ".";
	    return false;
	}
    } else {
	if (this.value.indexOf(".") === this.value.length - 3) {
	    return false;
	}
    }
    return /\d/.test(String.fromCharCode(teclaPulsada));
});
$(".visa").keypress(function (e) {
    var teclaPulsada = window.event ? window.event.keyCode : e.which;
    return /\d/.test(String.fromCharCode(teclaPulsada));
});
$(".visa").keyup(function () {
    if (this.value.length === 4) {
	var id = parseInt(this.id.substring(4));
	$("#visa" + (id + 1)).focus();
    }
});
function enviarSuscripcion() {
    $.ajax({
	data: $("#form-suscripcion").serialize(),
	url: "script/suscripcion.php",
	type: 'POST',
	success: function (response) {
	    var exito = JSON.parse(response);
	    if (exito) {
		alert("Se ha registrado correctamente. Pulse aceptar para redirigir.");
		location.href = "../index.php";
	    } else {
		alert("No se ha podido registrar");
	    }
	}
    });
}

function iniciarSesion() {
    $.ajax({
	data: $("#form-iniciarSesion").serialize(),
	url: "script/iniciar_sesion.php",
	type: 'POST',
	success: function (response) {
	    var exito = JSON.parse(response);
	    if (exito) {
		location.reload();
	    } else {
		alert("Usuario o contraseña invalidos");
	    }
	}
    });
}

function agregarCamposCanciones() {
    var n_canciones = $("#form-agregardisco tr.cancion").length;
    var str = '<tr class="cancion">';
    str += '<td class="etiqueta">Canción ' + (n_canciones + 1) + '</td>';
    str += '<td class="input">';
    str += 'Título <input type="text" id="tituloCancion' + (n_canciones + 1) + '" name="tituloCanciones[]"><p class="error"></p><br>';
    str += 'Música <input type="file" id="musicaCancion' + (n_canciones + 1) + '" name="musicaCanciones[]"><br></td></tr>';
    $("#form-agregardisco table tbody").append(str);
}
$('form#form-agregardisco #artista').keypress(function (e) {
    var teclaPulsada = window.event ? window.event.keyCode : e.which;
    var letra = String.fromCharCode(teclaPulsada);
    if(/\w/.test(letra)){
	$.ajax({
	data: {"nombre": this.value + letra},
	url: "script/obtener_artistas.php",
	type: 'POST',
	success: function (response) {
	    var artistas = JSON.parse(response);
	    var options = $('form#form-agregardisco #artistas');
	    options.empty();
	    for (var i in artistas) {
		var option = document.createElement('option');
		option.value = artistas[i].artista;
		options.append(option);
	    }
	}
    });
    }
//    return /\d/.test(String.fromCharCode(teclaPulsada));
});
//$('form#form-agregardisco #artista').keyup(function () {
//    $.ajax({
//	data: {"nombre": this.value},
//	url: "script/obtener_artistas.php",
//	type: 'POST',
//	success: function (response) {
//	    var artistas = JSON.parse(response);
//	    var options = $('form#form-agregardisco #artistas');
//	    options.empty();
//	    for (var i in artistas) {
//		var option = document.createElement('option');
//		option.value = artistas[i].artista;
//		options.append(option);
//	    }
//	}
//    });
//});

function agregarComentario() {
    $.ajax({
	data: $('#form-agregarcomentario').serialize(),
	url: "script/agregar_comentario.php",
	type: 'POST',
	success: function (response) {
	    var exito = JSON.parse(response);
	    if (exito) {
		alert("El comentario se ha añadido correctamente. Pulse aceptar para verlo.");
		location.reload();
	    } else {
		alert("No se ha podido registrar el comentario.");
	    }
	}
    });
}

function comprarDisco() {
    $.ajax({
	data: $('#form-comprardisco').serialize(),
	url: "script/comprar.php",
	type: 'POST',
	success: function (response) {
	    if (response == "iniciaSesion") {
		alert("Para comprar un disco tienes que iniciar sesión.");
		$('#usuario').focus();
	    } else {
		var exito = JSON.parse(response);
		if (exito) {
		    alert("El disco se ha comprado correctamente.");
		} else {
		    alert("No se ha podido comprar el disco.");
		}
	    }
	}
    });
}

$('section.titulo-disco h1').mouseenter(function () {
    $('section.lista-canciones').css('display', 'block');
    $('section.lista-canciones').css('left', $('section.titulo-disco h1').innerWidth() + 30);
});

$('section.titulo-disco h1').mouseout(function () {
    $('section.lista-canciones').css('display', 'none');
});

function validarSuscripcion() {
    var nombreFormulario = 'suscripcion';
    var camposRequeridos = ['nombre', 'apellidos', 'usuario', 'contrasenia', 'contrasenia2',
	'direccion', 'ciudad', 'provincia', 'codigoPostal', 'email', 'dni', 'visa1', 'visa2',
	'visa3', 'visa4'];
    var exito = true;
    for (var i in camposRequeridos) {
	var campo = camposRequeridos[i];
	var valor = $('#form-' + nombreFormulario + ' #' + campo).val().trim();
	if (valor == "") {
	    if (exito) {
		exito = false;
		$('#form-' + nombreFormulario + ' #' + campo).focus();
	    }
	    mostrarError(nombreFormulario, campo, 'Este campo es requerido.');
	} else {
	    quitarError(nombreFormulario, campo);
	}
    }
    var form = $('#form-' + nombreFormulario)[0];
    var patronEmail = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
    if (!patronEmail.test(form.email.value)) {
	if (exito) {
	    form.email.focus();
	    exito = false;
	}
	mostrarError(nombreFormulario, 'email', 'Formato incorrecto.')
    } else {
	quitarError(nombreFormulario, 'email')
    }
    if (form.contrasenia.value.length < 6) {
	if (exito) {
	    form.contrasenia.focus();
	    exito = false;
	}
	mostrarError(nombreFormulario, 'contrasenia', 'Longitud mínima de 6 carácteres.');
    } else {
	quitarError(nombreFormulario, 'contrasenia');
	if (form.contrasenia.value != form.contrasenia2.value) {
	    if (exito) {
		form.contrasenia2.focus();
		exito = false;
	    }
	    mostrarError(nombreFormulario, 'contrasenia2', 'Las contraseñas no coinciden.');
	} else {
	    quitarError(nombreFormulario, 'contrasenia2');
	}
    }
    if (form.envio.value == "") {
	exito = false;
	mostrarError(nombreFormulario, 'semanal', 'Elija una opción');
    } else {
	quitarError(nombreFormulario, 'semanal');
    }
    if (exito) {
	if (!form.condiciones.checked) {
	    exito = false;
	    alert("Es obligatorio leer y aceptar los terminos y condiciones.")
	}
    }
    return exito;
}

function mostrarError(formulario, campo, mensaje) {
    var msgError = $('#form-' + formulario + ' #' + campo).parent().children('.error');
    if (mensaje == "" || msgError.html() == "") {
	msgError.html(mensaje);
    }
}

function quitarError(formulario, campo) {
    mostrarError(formulario, campo, "");
}

function validarComentario() {
    var exito = true;
    var valor = $('#form-agregarcomentario #comentario').val().trim();
    if (valor == "") {
	if (exito) {
	    exito = false;
	    $('#form-agregarcomentario #comentario').focus();
	}
	mostrarError('agregarcomentario', 'comentario', 'Este campo es requerido.');
    } else {
	if (valor.length > 200) {
	    if (exito) {
		exito = false;
		$('#form-agregarcomentario #comentario').focus();
	    }
	    quitarError('agregarcomentario', 'comentario');
	    mostrarError('agregarcomentario', 'comentario', 'Máximo 200 carácteres. (Hay ' + valor.length + ')');
	} else {
	    quitarError('agregarcomentario', 'comentario');
	}
    }
    valor = $('#form-agregarcomentario #valoracion').val().trim();
    if (valor == "") {
	if (exito) {
	    exito = false;
	    $('#form-agregarcomentario #valoracion').focus();
	}
	mostrarError('agregarcomentario', 'valoracion', 'Este campo es requerido.');
    } else {
	if (valor > 10 || valor < 0) {
	    if (exito) {
		exito = false;
		$('#form-agregarcomentario #valoracion').focus();
	    }
	    mostrarError('agregarcomentario', 'valoracion', 'La puntuación va de 0 a 10.');
	} else {
	    quitarError('agregarcomentario', 'valoracion');
	}
    }
    return exito;
}

function validarAgregarDisco() {
    var nombreFormulario = 'agregardisco';
    var camposRequeridos = ['titulo', 'artista', 'genero', 'productora', 'precio', 'portada'];
    var exito = true;
    for (var i in camposRequeridos) {
	var campo = camposRequeridos[i];
	var valor = $('#form-' + nombreFormulario + ' #' + campo).val().trim();
	if (valor == "") {
	    if (exito) {
		exito = false;
		$('#form-' + nombreFormulario + ' #' + campo).focus();
	    }
	    mostrarError(nombreFormulario, campo, 'Este campo es requerido.');
	} else {
	    quitarError(nombreFormulario, campo);
	}
    }
    var canciones = $('.cancion');
    for (var i=1; i<=canciones.length; i++){
	var campo = "tituloCancion" + i;
	var valor = $('#form-' + nombreFormulario + ' #' + campo).val().trim();
	if (valor == "") {
	    if (exito) {
		exito = false;
		$('#form-' + nombreFormulario + ' #' + campo).focus();
	    }
	    mostrarError(nombreFormulario, campo, 'Este campo es requerido.');
	} else {
	    quitarError(nombreFormulario, campo);
	}
    }
    return exito;
}