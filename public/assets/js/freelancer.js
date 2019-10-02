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
    formulario = document.getElementById(formulario_id);
    boton = document.getElementById(boton_id);
    if($(formulario).is(":visible")){
        $(formulario).hide(300);
        $(boton).html(mensaje1);
    }else{
        $(formulario).show(300);
        $(boton).html(mensaje0);
    }
}
function cambia_preguntas_faltantes(examen_cantidad_preguntas,preguntas_faltantes){
    let examen_cantidad_preguntas_elemento = document.getElementById(examen_cantidad_preguntas.id);
    let preguntas_faltantes_elemento = document.getElementById(preguntas_faltantes.id);
    let cantidad_maxima = parseInt(examen_cantidad_preguntas_elemento.value);
    preguntas_faltantes_elemento.innerHTML = cantidad_maxima * 1.5;
}

function agregarPreguntasPorTemaYNivel(listaPreguntas){
    let listaPreguntas_elemento = document.getElementById(listaPreguntas.id);
    let divLabelPreguntas = document.createElement('div');
    divLabelPreguntas.className = "col-xs-12 col-sm-12 table-row";

    let divBotonBorrar = document.createElement('div');
    divBotonBorrar.className = "col-xs-2 col-sm-2 table-row";

    let botonBorrar = document.createElement('button');
    botonBorrar.innerHTML = "-"
    botonBorrar.type = "button";
    botonBorrar.className = "btn btn-danger btn-block btn-lg";

    divBotonBorrar.appendChild(botonBorrar);

    let divSpan = document.createElement('div');
    divSpan.className = "col-xs-10 col-sm-10 table-row";

    let spanT = document.createElement('span');
    spanT.innerHTML = "Tema 2. 25 preguntas. Nivel de 2-3";

    divSpan.appendChild(spanT);
    
    divLabelPreguntas.appendChild(divBotonBorrar);
    divLabelPreguntas.appendChild(divSpan);
    listaPreguntas_elemento.appendChild(divLabelPreguntas);
}
