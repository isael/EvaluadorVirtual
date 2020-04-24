function agregarMensaje(elemento, mensaje){
	const id_elemento = elemento.getAttribute("id");
	const id_div_error = "error-"+id_elemento;
	const div_error = document.getElementById(id_div_error);
	if(div_error){
		div_error.innerHTML = mensaje;
	}else{
		let div = document.createElement("div");
		div.setAttribute("id", id_div_error);
		let parrafo = document.createElement("p");
		div.innerHTML = mensaje;
		div.classList.add("error-text");
		elemento.parentNode.appendChild(div);
	}
}

function esCampoVacio(passwordElement){
	let esCampoVacio = false;
	let mensaje = "El campo no puede ser vacío";
	if(!passwordElement.value || passwordElement.value.trim() === ''){
		esCampoVacio = true;
	}
	if(esCampoVacio){
		agregarMensaje(passwordElement,mensaje);
	}
	return esCampoVacio;
}

function esValidoNombreApellido(nombreApellidoElement){
	console.log(nombreApellidoElement);
	let esValido = true;
	let mensaje = "Error de formato";
	if(false){
		esValido = false;
	}
	if(!esValido){
		//Agrega mensaje en rojo en nombreApellidoElement2
	}
	return !esCampoVacio(nombreApellidoElement) && esValido;
}

function esValidoCorreo(correoElement){
	let esValido = true;
	let mensajeMalFormato = "Correo mal formado";
	let mensajeExistente = "Correo existente";
	if(false){
		esValido = false;
	}
	if(!esValido){
		//Agrega mensaje en rojo en correoElement2
	}
	return !esCampoVacio(correoElement) && esValido;
}

function esValidoNumeroTrabajador(NumTrabElement){
	let esValido = true;
	let mensajeMalFormato = "Error de formato";
	let mensajeExistente = "Número ya existente";
	if(false){
		esValido = false;
	}
	if(!esValido){
		//Agrega mensaje en rojo en NumTrabElement2
	}
	return !esCampoVacio(NumTrabElement) && esValido;
}

function esValidoNumeroCuenta(numCtaElement){
	let esValido = true;
	let mensajeMalFormato = "Error de formato";
	let mensajeExistente = "Número ya existente";
	if(false){
		esValido = false;
	}
	if(!esValido){
		//Agrega mensaje en rojo en numCtaElement2
	}
	return !esCampoVacio(numCtaElement) && esValido;
}

function esValidoPassword(passwordElement){
	let esValido = true;
	esValido = !esCampoVacio(passwordElement);
	return esValido;
}

function esValidoPasswordRepetido(passwordElement1,passwordElement2){
	let esValido = true;
	let mensaje = "Contraseña diferente";
	if(passwordElement1.value !== passwordElement2.value ){
		esValido = false;
	}
	if(!esValido){
		//Agrega mensaje en rojo en passwordElement2
	}
	return esValido;
}

function es_valido_formulario_registro_profesor(){
	let respuesta = true;

	let apellidosElement = document.getElementById("apellidos");
	let nombresElement = document.getElementById("nombres");
	let correoElement = document.getElementById("correo");
	let ntrabajadorElement = document.getElementById("ntrabajador");
	let pwd1Element = document.getElementById("pwd1");
	let pwd2Element = document.getElementById("pwd2");

	respuesta = esValidoNombreApellido(apellidosElement) && respuesta;
	respuesta = esValidoNombreApellido(nombresElement) && respuesta;
	respuesta = esValidoCorreo(correoElement) && respuesta;
	respuesta = esValidoNumeroTrabajador(ntrabajadorElement) && respuesta;
	validaPassword1 = esValidoPassword(pwd1Element);
	validaPassword2 = esValidoPassword(pwd2Element);
	if(validaPassword1 && validaPassword2){
		respuesta = esValidoPasswordRepetido(pwd1Element,pwd2Element) && respuesta;
	}else{
		respuesta = false;
	}
	return respuesta;
}

function es_valido_formulario_registro_alumno(){
	let respuesta = true;

	let apellidosElement = document.getElementById("apellidos");
	let nombresElement = document.getElementById("nombres");
	let correoElement = document.getElementById("correo");
	let ncuentaElement = document.getElementById("ncuenta");
	let pwd1Element = document.getElementById("pwd1");
	let pwd2Element = document.getElementById("pwd2");

	respuesta = esValidoNombreApellido(apellidosElement) && respuesta;
	respuesta = esValidoNombreApellido(nombresElement) && respuesta;
	respuesta = esValidoCorreo(correoElement) && respuesta;
	respuesta = esValidoNumeroTrabajador(ncuentaElement) && respuesta;
	validaPassword1 = esValidoPassword(pwd1Element);
	validaPassword2 = esValidoPassword(pwd2Element);
	if(validaPassword1 && validaPassword2){
		respuesta = esValidoPasswordRepetido(pwd1Element,pwd2Element) && respuesta;
	}else{
		respuesta = false;
	}
	return respuesta;
}