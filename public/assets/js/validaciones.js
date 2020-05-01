function agregar_mensaje(elemento, mensaje){
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

function limpiar_mensaje(elemento, mensaje){
	const id_elemento = elemento.getAttribute("id");
	const id_div_error = "error-"+id_elemento;
	const div_error = document.getElementById(id_div_error);
	if(div_error){
		elemento.nextElementSibling.remove();
	}
}

function es_campo_vacio(element, mensaje = "El campo no puede ser vacío"){
	let es_campo_vacio = false;
	if(!element.value || element.value.trim() === ''){
		es_campo_vacio = true;
	}
	if(es_campo_vacio){
		agregar_mensaje(element,mensaje);
	}
	return es_campo_vacio;
}

function es_valido_no_vacio(element) {
	let esValido = true;
	esValido = !es_campo_vacio(element);
	if(esValido){
		limpiar_mensaje(element);
	}
	return esValido;
}

function es_valido_nombre_apellido(nombreApellidoElement){
	let esValido = true;
	const mensaje = "Error de formato";
	const regex = new RegExp("[A-Za-zÁÉÍÓÚñáéíóúÑ\'\s]+",'i');
	if(nombreApellidoElement.value && !regex.test(nombreApellidoElement.value)){
		esValido = false;
	}
	if(!esValido){
		agregar_mensaje(nombreApellidoElement,mensaje);
	}
	esValido = !es_campo_vacio(nombreApellidoElement) && esValido;
	if(esValido){
		limpiar_mensaje(nombreApellidoElement);
	}
	return esValido;
}

function es_valido_correo(correoElement){
	let esValido = true;
	let mensaje = "Correo mal formado";
	const regex = new RegExp("^[a-z0-9_.+-]+@[a-z]+\.[a-z.]+$",'i');
	if(correoElement.value && !regex.test(correoElement.value)){
		esValido = false;
	}
	if(!esValido){
		agregar_mensaje(correoElement,mensaje);
	}
	esValido = !es_campo_vacio(correoElement) && esValido;
	if(esValido){
		limpiar_mensaje(correoElement);
	}
	return esValido;
}

function es_valida_clave_numerica(claveElement){	
	let esValido = true;
	let mensaje = "Error de formato";
	const regex = new RegExp("^[0-9]+$",'i');
	if(claveElement.value && !regex.test(claveElement.value)){
		esValido = false;
	}
	if(!esValido){
		agregar_mensaje(claveElement,mensaje);
	}
	if(claveElement.id.includes("clave"))
		mensaje="Falta Clave";
	else
		mensaje=undefined;
	esValido = !es_campo_vacio(claveElement,mensaje) && esValido;
	if(esValido){
		limpiar_mensaje(claveElement);
	}
	return esValido;
}

function es_valido_porcentaje(porcentajeElement) {
	let esValido = true;
	let mensaje = "Porcentaje inválido";
	let porcentaje = parseInt(porcentajeElement.value);
	porcentaje = isNaN(porcentaje) ? -1 : porcentaje;
	if(0 > porcentaje && porcentaje > 100){
		esValido = false;
	}
	if(!esValido){
		agregar_mensaje(porcentajeElement,mensaje);
	}
	if(esValido){
		limpiar_mensaje(porcentajeElement);
	}
	return esValido;
}

function es_valido_numero_trabajador(numTrabElement){
	let esValido = true;
	let mensaje = "Error de formato";
	const regex = new RegExp("^[0-9]+$",'i');
	if(numTrabElement.value && !regex.test(numTrabElement.value)){
		esValido = false;
	}
	if(!esValido){
		agregar_mensaje(numTrabElement,mensaje);
	}
	esValido = !es_campo_vacio(numTrabElement) && esValido;
	if(esValido){
		limpiar_mensaje(numTrabElement);
	}
	return esValido;
}

function esValidoNumeroCuenta(numCtaElement){
	let esValido = true;
	let mensaje = "Error de formato";
	const regex = new RegExp("^[0-9]+$",'i');
	if(numCtaElement.value && !regex.test(numCtaElement.value)){
		esValido = false;
	}
	if(!esValido){
		agregar_mensaje(numCtaElement,mensaje);
	}
	esValido = !es_campo_vacio(numCtaElement) && esValido;
	if(esValido){
		limpiar_mensaje(numCtaElement);
	}
	return esValido;
}

function es_valida_fecha(fechaElement){
	let esValido = true;
	let mensaje = "Error de formato";
	const regex = new RegExp("^([12][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01]))$",'i');
	if(fechaElement.value && !regex.test(fechaElement.value)){
		esValido = false;
	}
	if(!esValido){
		agregar_mensaje(fechaElement,mensaje);
	}
	esValido = !es_campo_vacio(fechaElement) && esValido;
	if(esValido){
		limpiar_mensaje(fechaElement);
	}
	return esValido;
}

function es_valido_password(passwordElement){
	let esValido = true;
	esValido = !es_campo_vacio(passwordElement);
	if(esValido){
		limpiar_mensaje(passwordElement);
	}
	return esValido;
}

function es_valido_passwordRepetido(passwordElement1,passwordElement2){
	let esValido = true;
	let mensaje = "Contraseña diferente";
	if(passwordElement1.value !== passwordElement2.value ){
		esValido = false;
	}
	if(!esValido){
		agregar_mensaje(passwordElement2,mensaje);
	}else{
		limpiar_mensaje(passwordElement2);
	}
	return esValido;
}

function es_cantidad_preguntas_valida(cantidadPreguntasElement,preguntasAgregadasElement,preguntasMultiploElement){
	let esValido = true;
	const mensaje = "Las preguntas son insuficientes para crear el examen.";
	let cantidadPreguntas = parseInt(cantidadPreguntasElement.value);
	let preguntasAgregadas = parseInt(preguntasAgregadasElement.value);
	let preguntasMultiplo = parseInt(preguntasMultiploElement.value);

	cantidadPreguntas = isNaN(cantidadPreguntas) ? 0 : cantidadPreguntas;
	preguntasAgregadas = isNaN(preguntasAgregadas) ? 0 : preguntasAgregadas;
	preguntasMultiplo = isNaN(preguntasMultiplo) ? 0 : preguntasMultiplo;

	if(cantidadPreguntas * preguntasMultiplo > preguntasAgregadas){
		esValido = false;
	}
	if(!esValido){
		agregar_mensaje(preguntasAgregadasElement,mensaje);
	}
	esValido = !es_campo_vacio(preguntasAgregadasElement) && esValido;
	if(esValido){
		limpiar_mensaje(preguntasAgregadasElement);
	}

	return esValido;
}

function es_valido_cantidad_preguntas(cantidadPreguntasElement){
	let esValido = true;
	let mensaje = "Error de formato";
	const regex = new RegExp("^[0-9]+$",'i');
	if(cantidadPreguntasElement.value && !regex.test(cantidadPreguntasElement.value)){
		esValido = false;
	}else if(!cantidadPreguntasElement.value || parseInt(cantidadPreguntasElement.value) < 1){
		mensaje = "Cantidad de preguntas incorrecta";
		esValido = false;
	}
	if(!esValido){
		agregar_mensaje(cantidadPreguntasElement,mensaje);
	}
	esValido = !es_campo_vacio(cantidadPreguntasElement) && esValido;
	if(esValido){
		limpiar_mensaje(cantidadPreguntasElement);
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

	respuesta = es_valido_nombre_apellido(apellidosElement) && respuesta;
	respuesta = es_valido_nombre_apellido(nombresElement) && respuesta;
	respuesta = es_valido_correo(correoElement) && respuesta;
	respuesta = es_valido_numero_trabajador(ntrabajadorElement) && respuesta;
	validaPassword1 = es_valido_password(pwd1Element);
	validaPassword2 = es_valido_password(pwd2Element);
	if(validaPassword1 && validaPassword2){
		respuesta = es_valido_passwordRepetido(pwd1Element,pwd2Element) && respuesta;
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

	respuesta = es_valido_nombre_apellido(apellidosElement) && respuesta;
	respuesta = es_valido_nombre_apellido(nombresElement) && respuesta;
	respuesta = es_valido_correo(correoElement) && respuesta;
	respuesta = esValidoNumeroCuenta(ncuentaElement) && respuesta;
	validaPassword1 = es_valido_password(pwd1Element);
	validaPassword2 = es_valido_password(pwd2Element);
	if(validaPassword1 && validaPassword2){
		respuesta = es_valido_passwordRepetido(pwd1Element,pwd2Element) && respuesta;
	}else{
		respuesta = false;
	}
	return respuesta;
}

function es_valido_formulario_inicio_sesion(){
	let respuesta = true;

	let correoElement = document.getElementById("correo");
	let pwdElement = document.getElementById("pwd");

	respuesta = es_valido_correo(correoElement) && respuesta;
	respuesta = es_valido_password(pwdElement) && respuesta;
	return respuesta;
}

function es_valido_formulario_agregar_curso(){
	let respuesta = true;

	let claveElement = document.getElementById("form_clave_curso");
	let nombreElement = document.getElementById("form_nombre_curso");

	respuesta = es_valida_clave_numerica(claveElement) && respuesta;
	respuesta = es_valido_no_vacio(nombreElement) && respuesta;
	return respuesta;
}

function es_valido_formulario_modificar_curso(){
	let respuesta = true;
	let claveElement = document.getElementById("form_clave_curso_modificado");
	let nombreElement = document.getElementById("form_nombre_curso_modificado");
	let inicioElement = document.getElementById("form_inicio_curso_modificado");
	let finElement = document.getElementById("form_fin_curso_modificado");


	respuesta = es_valida_clave_numerica(claveElement) && respuesta;
	respuesta = es_valido_no_vacio(nombreElement) && respuesta;
	respuesta = es_valida_fecha(inicioElement) && respuesta;
	respuesta = es_valida_fecha(finElement) && respuesta;
	return respuesta;
}

function es_valido_formulario_solicitar_curso(){
	let respuesta = true;

	let claveElement = document.getElementById("form_clave_curso");

	respuesta = es_valida_clave_numerica(claveElement) && respuesta;
	return respuesta;
}

function es_valido_formulario_cambiar_nombre(){	
	let respuesta = true;

	let nombresElement = document.getElementById("nuevo_nombres");
	let apellidosElement = document.getElementById("nuevo_apellidos");
	let pwdElement = document.getElementById("pass_nuevo_nombre");

	respuesta = es_valido_nombre_apellido(apellidosElement) && respuesta;
	respuesta = es_valido_nombre_apellido(nombresElement) && respuesta;
	respuesta = es_valido_password(pwdElement) && respuesta;
	return respuesta;
}

function es_valido_formulario_cambiar_password(){	
	let respuesta = true;

	let viejoPasswordElement = document.getElementById("anterior_pass");
	let nuevoPassword1Element = document.getElementById("nuevo_pass");
	let nuevoPassword2Element = document.getElementById("nuevo_pass_rep");

	respuesta = es_valido_password(viejoPasswordElement) && respuesta;
	validaPassword1 = es_valido_password(nuevoPassword1Element);
	validaPassword2 = es_valido_password(nuevoPassword2Element);
	if(validaPassword1 && validaPassword2){
		respuesta = es_valido_passwordRepetido(nuevoPassword1Element,nuevoPassword2Element) && respuesta;
	}else{
		respuesta = false;
	}
	return respuesta;
}

function es_valido_formulario_cambiar_correo(){	
	let respuesta = true;

	let correoElement = document.getElementById("nuevo_correo");
	let pwdElement = document.getElementById("pass_nuevo_correo");

	respuesta = es_valido_correo(correoElement) && respuesta;
	respuesta = es_valido_password(pwdElement) && respuesta;
	return respuesta;
}

function es_valido_formulario_crear_examen(sufijoModal = ""){	
	let respuesta = true;

	let nombreElement = document.getElementById("form_examen_nombre"+sufijoModal);
	let vidasElement = document.getElementById("examen_vidas"+sufijoModal+"_option_selected");
	let oportunidadesElement = document.getElementById("examen_oportunidades"+sufijoModal+"_option_selected");
	let inicioElement = document.getElementById("form_examen_inicio"+sufijoModal);
	let finalElement = document.getElementById("form_examen_final"+sufijoModal);
	let cantidadPreguntasElement = document.getElementById("form_examen_cantidad_preguntas"+sufijoModal);

	let preguntasAgregadasElement = document.getElementById("form_preguntas_agregadas"+sufijoModal);
	let preguntasMultiploElement = document.getElementById("form_preguntas_multiplo"+sufijoModal);

	respuesta = es_valido_no_vacio(nombreElement) && respuesta;
	respuesta = es_valido_no_vacio(vidasElement) && respuesta;
	respuesta = es_valido_no_vacio(oportunidadesElement) && respuesta;
	respuesta = es_valida_fecha(inicioElement) && respuesta;
	respuesta = es_valida_fecha(finalElement) && respuesta;
	respuesta = es_valido_cantidad_preguntas(cantidadPreguntasElement) && respuesta;
	respuesta = es_cantidad_preguntas_valida(cantidadPreguntasElement,preguntasAgregadasElement,preguntasMultiploElement) && respuesta;

	return respuesta;
}

function es_valido_formulario_crear_bibliografia(sufijoModal = ""){	
	let respuesta = true;

	let nombreElement = document.getElementById("form_nombre_bibliografia"+sufijoModal);
	let autorElement = document.getElementById("form_autor_bibliografia"+sufijoModal);
	let numeroElement = document.getElementById("form_numero_edicion_bibliografia"+sufijoModal);
	let anioElement = document.getElementById("form_anio_bibliografia"+sufijoModal);

	respuesta = es_valido_nombre_apellido(nombreElement) && respuesta;
	respuesta = es_valido_nombre_apellido(autorElement) && respuesta;
	respuesta = es_valida_clave_numerica(numeroElement,) && respuesta;
	respuesta = es_valida_clave_numerica(anioElement) && respuesta;

	return respuesta;
}

function es_valido_formulario_crear_pregunta(sufijoModal = ""){	
	let respuesta = true;

	let temaElement = document.getElementById("pregunta_tema"+sufijoModal);
	let bibliografiaElement = document.getElementById("pregunta_bibliografia"+sufijoModal);
	let paginaBibliografiaElement = document.getElementById("form_pregunta_bibliografia_pagina"+sufijoModal);
	let capituloBibliografiaElement = document.getElementById("form_pregunta_bibliografia_capitulo"+sufijoModal);
	let dificultadElement = document.getElementById("pregunta_dificultad"+sufijoModal);
	let tiempoElement = document.getElementById("form_pregunta_tiempo"+sufijoModal);
	let tipoElement = document.getElementById("pregunta_tipo"+sufijoModal);
	let preguntaElement = document.getElementById("form_pregunta_texto"+sufijoModal);
	let justificacionElement = document.getElementById("form_pregunta_justificacion"+sufijoModal);

	let hayRespuestas = es_valido_no_vacio(tipoElement);
	if(hayRespuestas){
		let cantidadRespuestasElement = document.getElementById("form_pregunta_cantidad_respuestas"+sufijoModal);
		let cantidadRespuestas = parseInt(cantidadRespuestasElement.value);
		cantidadRespuestas = isNaN(cantidadRespuestas) ? 0 : cantidadRespuestas;
		let respuestaActual = null;
		let porcentajeActual = null;
		let porcentajeMaximo = 0;
		for (var i = 1; i <= cantidadRespuestas; i++) {
			respuestaActual = document.getElementById("form_pregunta_respuesta_"+i+sufijoModal);
			porcentajeActual = document.getElementById("form_pregunta_respuesta_porcentaje_"+i+sufijoModal);
			respuesta = es_valido_no_vacio(respuestaActual) && respuesta;
			respuesta = es_valido_porcentaje(porcentajeActual) && respuesta;
			if(porcentajeActual && porcentajeActual.value && parseInt(porcentajeActual.value)){
				let porciento = parseInt(porcentajeActual.value);
				if(!isNaN(porciento) && porciento > porcentajeMaximo){
					porcentajeMaximo = porciento
				}
			}
			if(i == cantidadRespuestas){
				if(porcentajeMaximo < 100){
					respuesta = false;
					agregar_mensaje(porcentajeActual,"Falta algún porcentaje con 100%");
				}else{
					limpiar_mensaje(porcentajeActual);
				}
			}
		}
	}else{
		respuesta = false;
	}

	respuesta = es_valido_nombre_apellido(temaElement) && respuesta;
	respuesta = es_valido_no_vacio(bibliografiaElement) && respuesta;
	respuesta = es_valida_clave_numerica(paginaBibliografiaElement) && respuesta;
	respuesta = es_valida_clave_numerica(capituloBibliografiaElement) && respuesta;
	respuesta = es_valida_clave_numerica(dificultadElement) && respuesta;
	respuesta = es_valida_clave_numerica(tiempoElement) && respuesta;
	respuesta = es_valido_no_vacio(preguntaElement) && respuesta;
	respuesta = es_valido_no_vacio(justificacionElement) && respuesta;

	return respuesta;
}