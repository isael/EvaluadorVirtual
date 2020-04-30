// Freelancer Theme JavaScript

(function($) {
    "use strict"; // Start of use strict

    // jQuery for page scrolling feature - requires jQuery Easing plugin. But we don't need it.
    /**
    $('.page-scroll a').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top - 50)
        }, 1250, 'easeInOutExpo');
        event.preventDefault();
    });
    **/

    // Highlight the top nav as scrolling occurs
    $('body').scrollspy({
        target: '.navbar-fixed-top',
        offset: 51
    });

    // Closes the Responsive Menu on Menu Item Click
    $('.navbar-collapse ul li a:not(.dropdown-toggle)').click(function() {
        $('.navbar-toggle:visible').click();
    });

    // Offset for Main Navigation
    $('#mainNav').affix({
        offset: {
            top: 100
        }
    })

    // Floating label headings for the contact form
    $(function() {
        $("body").on("input propertychange", ".floating-label-form-group", function(e) {
            $(this).toggleClass("floating-label-form-group-with-value", !!$(e.target).val());
        }).on("focus", ".floating-label-form-group", function() {
            $(this).addClass("floating-label-form-group-with-focus");
        }).on("blur", ".floating-label-form-group", function() {
            $(this).removeClass("floating-label-form-group-with-focus");
        });
    });
    $(function() {
        $(".alert").fadeOut(10000);
    },1000);

    $('#modalFoto').on('change','#nueva_foto' , function(){
        var input = $(this);
        $('#texto_nueva_foto').val(input.val());
        //uploadFile();
    });
    $('#cabecera').on('change','#check_todos' , function(){
        if ($('#check_todos').is(':checked')) {
            //$("input[type=checkbox]").prop('checked', true); //todos los check
            $("#form_alumnos input[type=checkbox]").prop('checked', true); //solo los del objeto #form_alumnos
        } else {
            //$("input[type=checkbox]").prop('checked', false);//todos los check
            $("#form_alumnos input[type=checkbox]").prop('checked', false);//solo los del objeto #form_alumnos
        }
    });


})(jQuery); // End of use strict

window.onpageshow = function(evt) {
    // If persisted then it is in the page cache, force a reload of the page.
    if (evt.persisted) {
        document.body.style.display = "none";
        location.reload();
    }
};
function cambiarPestania(pestanias,pestania) {
    
    pestania = document.getElementById(pestania.id);
    listaPestanias = document.getElementById(pestanias.id);
    
    area = document.getElementById('area_'+pestania.id);
    listaAreas = document.getElementById('area_'+pestanias.id);
    
    i=0;
    // Recorre la lista ocultando todas las pestañas y restaurando el fondo 
    // y el padding de las pestañas.
    while (typeof listaAreas.getElementsByTagName('div')[i] != 'undefined'){
        $(document).ready(function(){
            //$(listaAreas.getElementsByTagName('div')[i]).css('display','none');
            $(listaAreas.getElementsByClassName('area')[i]).addClass('oculto');
            $(listaAreas.getElementsByClassName('area')[i]).removeClass('expuesto');
            $(listaPestanias.getElementsByTagName('li')[i]).removeClass('active');
        });
        i += 1;
    }
 
    $(document).ready(function(){
        // Muestra el contenido de la pestaña pasada como parametro a la funcion,
        // cambia el color de la pestaña y aumenta el padding para que tape el  
        // borde superior del contenido que esta juesto debajo y se vea de este 
        // modo que esta seleccionada.
        //$(area).css('display','');
        $(area).addClass('expuesto');
        $(area).removeClass('oculto');
        $(pestania).addClass('active');
    });
 
}

function mostrarFormulario(boton_id,formulario_id,mensaje1,mensaje0){
    const formulario = document.getElementById(formulario_id);
    let boton = document.getElementById(boton_id);
    if($(formulario).is(":visible")){
        $(formulario).hide(300);
        $(boton).html(mensaje1);
    }else{
        $(formulario).show(300);
        $(boton).html(mensaje0);
        let otros_formularios = document.getElementsByName("visibleToogle");
        let formulario_aux = null;
        otros_formularios.forEach(element => {
            if(element.id !== boton.id){
                formulario_aux = document.getElementById(element.getAttribute("relatedForm"));
                if($(formulario_aux).is(":visible")){
                    $(element).click();
                }
            }
        });
    }
}

function cambia_preguntas_faltantes(esModal){
    let sufijo_modal = esModal ? "_modal" : "";
    let examen_cantidad_preguntas_elemento = document.getElementById("examen_cantidad_preguntas"+sufijo_modal) || document.getElementById("form_examen_cantidad_preguntas"+sufijo_modal);
    let preguntas_faltantes_elemento = document.getElementById("preguntas_faltantes"+sufijo_modal) || document.getElementById("form_preguntas_faltantes"+sufijo_modal);
    let preguntas_agregadas_elemento = document.getElementById("preguntas_agregadas"+sufijo_modal) || document.getElementById("form_preguntas_agregadas"+sufijo_modal);
    let cantidad_maxima = parseInt(examen_cantidad_preguntas_elemento.value);
    let cantidad_actual = parseInt(preguntas_agregadas_elemento.value);
    cantidad_actual = cantidad_actual > (cantidad_maxima * 1.5) ? (cantidad_maxima * 1.5) : cantidad_actual;
    preguntas_faltantes_elemento.innerHTML = (cantidad_maxima * 1.5) - cantidad_actual;
}

function limpiaEliminar(e, botonBorrar, divBotonBorrar) {
    if (e.target !== botonBorrar){
        botonBorrar.innerHTML = "-";
        divBotonBorrar.className = "col-xs-1 col-sm-1 table-row";
    }
}

function limpiaAgregarPreguntas(tema_elemento,tema_elemento_texto,desde_elemento,desde_elemento_texto,hasta_elemento,hasta_elemento_texto,boton_cancelar_tema,es_rellenado){
    tema_elemento.value = "";
    tema_elemento_texto.value = "";
    desde_elemento.value = "1";
    desde_elemento_texto.value = "1";
    hasta_elemento.value = "3";
    hasta_elemento_texto.value = "3";
    if(!es_rellenado){
        boton_cancelar_tema.click();
    }
}

function agregarValoresAlInputEscondido(lista_preguntas_elemento,esModal,tema_elemento,desde_elemento,hasta_elemento,es_rellenado) {
    let sufijo_modal = esModal ? "_modal" : "";
    const id = "examen_temas"+sufijo_modal;
    let input_escondido = document.getElementById(id);
    let arreglo_valores = [tema_elemento.value+"-"+desde_elemento.value+"-"+hasta_elemento.value];
    let regex = new RegExp("^"+tema_elemento.value);
    let tema_previo = false;
    if(input_escondido){
        if(es_rellenado){
            arreglo_valores = input_escondido.value.split(",");
        }else if(!input_escondido.value || input_escondido.value === ""){
            input_escondido.value = arreglo_valores;
        }else{
            let arreglo = input_escondido.value.split(",");

            for (let i = 0; i < arreglo.length; i++) {
                let valor = arreglo[i];
                if(valor.match(regex)){
                    tema_previo=true;
                    alert("Ya hay un grupo de preguntas con este tema. Se tomarán preguntas desde el mínimo nivel hasta el máximo nivel que hayan sido declarados hasta ahora.")
                    tema_rango = valor.split('-');
                    let minimo = desde_elemento.value < tema_rango[1] ? desde_elemento.value : tema_rango[1];
                    let maximo = hasta_elemento.value > tema_rango[2] ? hasta_elemento.value : tema_rango[2];
                    const span_elemento = document.getElementById('span_'+tema_elemento.value+sufijo_modal);
                    if(span_elemento){
                        tema_rango[1] = minimo;
                        tema_rango[2] = maximo;
                        span_elemento.innerHTML = getTextoSpan(tema_rango);
                    }
                    arreglo[i] = tema_elemento.value+"-"+minimo+"-"+maximo;
                    i=arreglo.length;
                }
            }
            if(!tema_previo){
                arreglo.push(tema_elemento.value+"-"+desde_elemento.value+"-"+hasta_elemento.value);            
            }
            input_escondido.value = arreglo;
            arreglo_valores = arreglo;
        }
    }else{
        input_escondido = document.createElement('input');
        input_escondido.type = "hidden";
        input_escondido.id = id;
        input_escondido.name = id;
        input_escondido.value = arreglo_valores;
        lista_preguntas_elemento.appendChild(input_escondido);
    }
    return arreglo_valores;
}

function quitarValoresAlInputEscondido(esModal,tema_elemento_value,desde_elemento_value,hasta_elemento_value) {
    let sufijo_modal = esModal ? "_modal" : "";
    const id = "examen_temas"+sufijo_modal;
    let input_escondido = document.getElementById(id);
    if(input_escondido){
        let arreglo = input_escondido.value.split(",");
        let posicion = (-1);
        let regex = new RegExp("^"+tema_elemento_value);
        for(let i=0; i<arreglo.length; i++){
            if(arreglo[i].match(regex)){
                posicion = i;
                i = arreglo.length;
            }
        }
        posicion !== -1 && arreglo.splice( posicion, 1 );
        input_escondido.value = arreglo;
    }
}

function getTextoSpan(tema_rango, es_para_nombre_de_tema) {
    //const arreglo_texto = tema_elemento_texto.value.split(':');
    let texto_span = '';
    if(tema_rango){
        if(es_para_nombre_de_tema){
            const tema_texto_emento = document.getElementById('input_tema_'+tema_rango[0]) || document.getElementById('form_input_tema_'+tema_rango[0]);
            texto_span = tema_texto_emento.value+". &nbsp;&nbsp;&nbsp;&nbsp;Cantidad de preguntas:";
        }else{
            const preguntas_texto = document.getElementById('input_'+tema_rango[0]) || document.getElementById('form_input_'+tema_rango[0]);
            const arreglo_preguntas_texto = preguntas_texto.value.split(',');
            texto_span = "";
            for(let i = parseInt(tema_rango[1]); i <= parseInt(tema_rango[2]); i++ ){
                texto_span = texto_span + " N"+ i + ": " + arreglo_preguntas_texto[i-1];
                if(i < parseInt(tema_rango[2])){
                    texto_span = texto_span + ", ";
                }
            }            
        }
    }
    return texto_span;
}

function actualizarPreguntasAgregadas(esModal = false){
    let sufijo_modal = esModal ? "_modal" : "";
    let preguntas_agregadas = document.getElementById('preguntas_agregadas'+sufijo_modal) || document.getElementById('form_preguntas_agregadas'+sufijo_modal);
    const id = "examen_temas"+sufijo_modal;
    let input_escondido = document.getElementById(id);
    let arreglo = input_escondido.value.split(",");
    let suma = 0;
    for (let i = 0; i < arreglo.length; i++) {
        let valor = arreglo[i];
        if(valor && valor!==''){
            tema_rango = valor.split('-');

            let preguntas_texto = document.getElementById('input_'+tema_rango[0]) || document.getElementById('form_input_'+tema_rango[0]);
            if(preguntas_texto){
                let cantidades = preguntas_texto.value.split(',');

                for(let j = parseInt(tema_rango[1]); j <= parseInt(tema_rango[2]); j++){
                    suma = suma + parseInt(cantidades[j-1]);
                }
            }
        }
    }
    preguntas_agregadas.value = suma;
    cambia_preguntas_faltantes(esModal);
}

function agregarPreguntasPorTemaYNivel(listaPreguntas, tema, desde, hasta, esModal = false, es_rellenado = false){
    let sufijo_modal = esModal ? "_modal" : "";
    let lista_preguntas_elemento = document.getElementById(listaPreguntas.id+sufijo_modal);
    let tema_elemento_texto = document.getElementById(tema.id+sufijo_modal);
    let tema_elemento = document.getElementById(tema.id+sufijo_modal+'_option_selected');
    let desde_elemento_texto = document.getElementById(desde.id+sufijo_modal);
    let desde_elemento = document.getElementById(desde.id+sufijo_modal+'_option_selected');
    let hasta_elemento_texto = document.getElementById(hasta.id+sufijo_modal);
    let hasta_elemento = document.getElementById(hasta.id+sufijo_modal+'_option_selected');

    if(!tema_elemento || tema_elemento.value === ''){
        alert("Falta agregar tema");
        return;
    }
    if(parseInt(desde_elemento.value) > parseInt(hasta_elemento.value)){
        alert("El valor del nivel Desde no puede ser menor al valor del Hasta");
        return;        
    }

    let arreglo_valores = agregarValoresAlInputEscondido(lista_preguntas_elemento,esModal,tema_elemento,desde_elemento,hasta_elemento,es_rellenado);
    const span_elemento = document.getElementById('span_'+tema_elemento.value+sufijo_modal);
    if(!span_elemento){

        let divLabelPreguntas = document.createElement('div');
        divLabelPreguntas.className = "col-xs-12 col-sm-12 table-row";

        let divBotonBorrar = document.createElement('div');
        divBotonBorrar.className = "col-xs-1 col-sm-1 table-row";


        let botonBorrar = document.createElement('button');
        botonBorrar.innerHTML = "-";
        botonBorrar.type = "button";
        botonBorrar.className = "btn btn-danger btn-block btn-lg";
        let funcionAnomina = function(e){limpiaEliminar(e,botonBorrar,divBotonBorrar)};
        let tema_elemento_value = tema_elemento.value;
        let desde_elemento_value = desde_elemento.value;
        let hasta_elemento_value = hasta_elemento.value;
        botonBorrar.onclick = function(){
            if(botonBorrar.innerHTML === "-"){
                botonBorrar.innerHTML = "Eliminar";
                divBotonBorrar.className = "col-xs-2 col-sm-2 table-row";
            }else{
                document.removeEventListener('click', funcionAnomina);
                lista_preguntas_elemento.removeChild(divLabelPreguntas);
                quitarValoresAlInputEscondido(esModal,tema_elemento_value,desde_elemento_value,hasta_elemento_value);
                actualizarPreguntasAgregadas(esModal);
            }
        };
        document.removeEventListener('click', funcionAnomina);
        document.addEventListener('click', funcionAnomina);

        divBotonBorrar.appendChild(botonBorrar);

        let divSpan = document.createElement('div');
        divSpan.className = "col-xs-10 col-sm-10 table-row";

        let tema_rango = null;
        let regex = new RegExp("^"+tema_elemento.value);
        for (let i = 0; i < arreglo_valores.length; i++) {
            let valor = arreglo_valores[i];
            if(valor.match(regex)){
                tema_rango = valor.split('-');
                i=arreglo_valores.length;
            }
        }

        let spanT = document.createElement('span');
        let texto_span = getTextoSpan(tema_rango, true);
        spanT.innerHTML = texto_span;

        let spanPreguntas = document.createElement('span');
        spanPreguntas.id = 'span_'+tema_elemento.value+sufijo_modal;
        let texto_span_preguntas = getTextoSpan(tema_rango);
        spanPreguntas.innerHTML = texto_span_preguntas;

        divSpan.appendChild(spanT);
        divSpan.appendChild(spanPreguntas);
        
        divLabelPreguntas.appendChild(divBotonBorrar);
        divLabelPreguntas.appendChild(divSpan);
        lista_preguntas_elemento.appendChild(divLabelPreguntas);
    }
    let boton_cancelar_tema = document.getElementById('mostrarAgregarPreguntasPorTema'+sufijo_modal);
    limpiaAgregarPreguntas(tema_elemento,tema_elemento_texto,desde_elemento,desde_elemento_texto,hasta_elemento,hasta_elemento_texto,boton_cancelar_tema,es_rellenado);
    actualizarPreguntasAgregadas(esModal);
}

function rellenar_modal_examen_con_temas(inputOculto, listaPreguntas, tema, desde, hasta) {
    let input_oculto_elemento = document.getElementById(inputOculto.id);
    let tema_elemento_modal = document.getElementById(tema.id+'_modal'+'_option_selected');
    let desde_elemento_modal = document.getElementById(desde.id+'_modal'+'_option_selected');
    let hasta_elemento_modal = document.getElementById(hasta.id+'_modal'+'_option_selected');

    let arreglo = input_oculto_elemento.value.split(",");

    for (let i = 0; i < arreglo.length; i++) {
        let valor = arreglo[i];
        tema_rango = valor.split('-');
        let tema_id = tema_rango[0];
        let tema_desde = tema_rango[1];
        let tema_hasta = tema_rango[2];

        tema_elemento_modal.value = tema_id;
        desde_elemento_modal.value = tema_desde;
        hasta_elemento_modal.value = tema_hasta;

        agregarPreguntasPorTemaYNivel(listaPreguntas, tema, desde, hasta, true, true);
    }
    let lista_preguntas_elemento = document.getElementById(listaPreguntas.id+'_modal');
    let br = document.createElement('br');
    lista_preguntas_elemento.appendChild(br)
}

function agregaEstiloSelected(respuesta,otras_respuestas) {
    let respuestas_arreglo = otras_respuestas.childNodes;
    for (let i = 0; i < respuestas_arreglo.length ; i++) {
        if(respuestas_arreglo[i].tagName === 'A')
            respuestas_arreglo[i].classList.remove('seleccionada');
    }
    respuesta.classList.add('seleccionada');
    let input_respuesta = document.getElementById('respuesta_elegida') || document.getElementById('form_respuesta_elegida');
    let string = "respuesta_";
    input_respuesta.value = respuesta.id.substring(string.length);
    //habilitar el boton de pregunta.
}

function waiting() {
    const span_elemento = document.getElementById('tiempo');
    let tiempo = span_elemento.innerHTML;
    let begin = new Date();
    const final = begin.getTime()+(parseInt(tiempo)+5)*1000;
    let diferencia = 0;
    let cuenta_regresiva = function () {
        begin = new Date();
        diferencia = final - begin.getTime();
        console.log(diferencia, final, begin.getTime());
        if(diferencia < 0){
            alert("intentaste hacer trampa");
            let input_respuesta = document.getElementById('respuesta_elegida') || document.getElementById('form_respuesta_elegida');
            input_respuesta.value = '-1';
            let sumbit = document.getElementById('boton_evaluar') || document.getElementById('form_boton_evaluar');
            sumbit.click();
        }else{
            span_elemento.innerHTML = tiempo;       
            if(tiempo == 0){
                let sumbit = document.getElementById('boton_evaluar') || document.getElementById('form_boton_evaluar');
                sumbit.click();
            }else{
                setTimeout(function(){
                    tiempo--;
                    cuenta_regresiva();
                },1000);
            }           
        }
    }
    cuenta_regresiva();
}