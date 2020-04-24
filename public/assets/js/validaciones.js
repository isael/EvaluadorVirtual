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

function limpiarMensaje(elemento, mensaje){
	const id_elemento = elemento.getAttribute("id");
	const id_div_error = "error-"+id_elemento;
	const div_error = document.getElementById(id_div_error);
	if(div_error){
		elemento.nextElementSibling.remove();
	}
}

function esCampoVacio(element, mensaje = "El campo no puede ser vacío"){
	let esCampoVacio = false;
	if(!element.value || element.value.trim() === ''){
		esCampoVacio = true;
	}
	if(esCampoVacio){
		agregarMensaje(element,mensaje);
	}
	return esCampoVacio;
}

function esValidoNombreApellido(nombreApellidoElement){
	console.log(nombreApellidoElement);
	let esValido = true;
	const mensaje = "Error de formato";
	const regex = new RegExp("[A-Za-zÁÉÍÓÚñáéíóúÑ\'\s]+",'i');
	if(nombreApellidoElement.value && !regex.test(nombreApellidoElement.value)){
		esValido = false;
	}
	if(!esValido){
		agregarMensaje(nombreApellidoElement,mensaje);
	}
	esValido = !esCampoVacio(nombreApellidoElement) && esValido;
	if(esValido){
		limpiarMensaje(nombreApellidoElement);
	}
	return esValido;
}

function esValidoCorreo(correoElement){
	let esValido = true;
	let mensaje = "Correo mal formado";
	const regex = new RegExp("^[a-z0-9_.+-]+@[a-z]+\.[a-z.]+$",'i');
	if(correoElement.value && !regex.test(correoElement.value)){
		esValido = false;
	}
	if(!esValido){
		agregarMensaje(correoElement,mensaje);
	}
	esValido = !esCampoVacio(correoElement) && esValido;
	if(esValido){
		limpiarMensaje(correoElement);
	}
	return esValido;
}

function esValidaClaveNumerica(claveElement){	
	let esValido = true;
	let mensaje = "Error de formato";
	const regex = new RegExp("^[0-9]+$",'i');
	if(claveElement.value && !regex.test(claveElement.value)){
		esValido = false;
	}
	if(!esValido){
		agregarMensaje(claveElement,mensaje);
	}
	esValido = !esCampoVacio(claveElement,"Falta Clave") && esValido;
	if(esValido){
		limpiarMensaje(claveElement);
	}
	return esValido;
}

function esValidoNumeroTrabajador(numTrabElement){
	let esValido = true;
	let mensaje = "Error de formato";
	const regex = new RegExp("^[0-9]+$",'i');
	if(numTrabElement.value && !regex.test(numTrabElement.value)){
		esValido = false;
	}
	if(!esValido){
		agregarMensaje(numTrabElement,mensaje);
	}
	esValido = !esCampoVacio(numTrabElement) && esValido;
	if(esValido){
		limpiarMensaje(numTrabElement);
	}
	return esValido;
}

function esValidoNumeroCuenta(numCtaElement){
	let esValido = true;
	let mensaje = "Error de formato";
	const regex = new RegExp("^[0-9]+$",'i');
	if(correoElement.value && !regex.test(numCtaElement.value)){
		esValido = false;
	}
	if(!esValido){
		agregarMensaje(numCtaElement,mensaje);
	}
	esValido = !esCampoVacio(numCtaElement) && esValido;
	if(esValido){
		limpiarMensaje(numCtaElement);
	}
	return esValido;
}

function esValidoPassword(passwordElement){
	let esValido = true;
	esValido = !esCampoVacio(passwordElement);
	if(esValido){
		limpiarMensaje(passwordElement);
	}
	return esValido;
}

function esValidoPasswordRepetido(passwordElement1,passwordElement2){
	let esValido = true;
	let mensaje = "Contraseña diferente";
	if(passwordElement1.value !== passwordElement2.value ){
		esValido = false;
	}
	if(!esValido){
		agregarMensaje(passwordElement2,mensaje);
	}else{
		limpiarMensaje(passwordElement2);
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
	respuesta = esValidoNumeroCuenta(ncuentaElement) && respuesta;
	validaPassword1 = esValidoPassword(pwd1Element);
	validaPassword2 = esValidoPassword(pwd2Element);
	if(validaPassword1 && validaPassword2){
		respuesta = esValidoPasswordRepetido(pwd1Element,pwd2Element) && respuesta;
	}else{
		respuesta = false;
	}
	return respuesta;
}

function es_valido_formulario_inicio_sesion(){
	let respuesta = true;

	let correoElement = document.getElementById("correo");
	let pwdElement = document.getElementById("pwd");

	respuesta = esValidoCorreo(correoElement) && respuesta;
	validaPassword1 = esValidoPassword(pwdElement) && respuesta;
	return respuesta;
}

function es_valido_formulario_agregar_curso(){
	let respuesta = true;

	let claveElement = document.getElementById("form_clave_curso");
	let nombreElement = document.getElementById("form_nombre_curso");

	respuesta = esValidaClaveNumerica(claveElement) && respuesta;
	validaPassword1 = !esCampoVacio(nombreElement) && respuesta;
	return respuesta;
}

function es_valido_formulario_solicitar_curso(){
	let respuesta = true;

	let claveElement = document.getElementById("form_clave_curso");

	respuesta = esValidaClaveNumerica(claveElement) && respuesta;
	return respuesta;
}