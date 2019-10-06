function toogleSelector(response, listResults){
    resultados = document.getElementById(listResults.id);
    if(resultados.style.visibility !== "visible"){
        respuesta = document.getElementById(response.id);
        respuesta.focus();
    }else{
        resultados.style.visibility="hidden";
        resultados.style.opacity="0";
    }
}

function handleFocus(results, focusIn){
    const resultados = document.getElementById(results.id);
    setTimeout(function(){
        if(focusIn){
            resultados.style.visibility="visible";
            resultados.style.opacity="1";
        }else{
            resultados.style.visibility="hidden";
            resultados.style.opacity="0";
        }
    },150);
}

function updateResponse(idSelected, results, textElement, text){
    let element = document.getElementById(textElement.id);
    element.value = text;
    hiddenElement = document.getElementById(textElement.id+"_option_selected");
    hiddenElement.value = idSelected;
    if(textElement.id === 'pregunta_tipo'){
        setNumeroRespuestas(idSelected);
    }
    toogleSelector(textElement, results);
}

function agregarNuevoElementoEnLista(modalInputId, resultsId, responseTextId, cancelButtonId){
    let cancelButton = document.getElementById(cancelButtonId.id);
    let responseText = document.getElementById(responseTextId.id);
    let text = document.getElementById(modalInputId.id).value;
    if(typeof text === 'string' && text !== ''){
        let element = document.getElementById(resultsId.id);
        let li = document.createElement("li");
        let anchor = document.createElement("a");
        anchor.setAttribute('href', "javascript:updateResponse('"+text+"',"+resultsId.id+","+responseTextId.id+",'"+text+"')");
        anchor.innerHTML = text;
        li.appendChild(anchor);
        element.insertBefore(li,element.firstChild);
        cancelButton.click();
        responseText.focus();
    }else{
        //TODO javascript error message
    }
}

function setNumeroRespuestas(idTipo){
    let minmax = types[idTipo];
    let numero = minmax[0];
    console.log("set Numero respuesta", numero);
    actualizaRespuestas(numero);
}

function actualizaRespuestas(cantidad){
    console.log("Actualizar Respuesta");
    let elementoRespuestas = document.getElementById('respuestas');
    let elementoCantidadRespuestas = document.getElementById('form_pregunta_cantidad_respuestas');
    elementoCantidadRespuestas.value=cantidad;
    elementoRespuestas.innerHTML = "";
    for (let i = 1; i <= cantidad; i++) {
        let nuevaRespuesta = document.createElement('div');
        nuevaRespuesta.className = "col-xs-12 col-sm-12 table";

        let divLabelRespuesta = document.createElement('div');
        divLabelRespuesta.className = "col-xs-1 col-sm-1 table-row";
        let labelR = document.createElement('label');
        labelR.innerHTML = "R."+i;
        labelR.htmlFor = "form_pregunta_respuesta_"+i;
        divLabelRespuesta.appendChild(labelR);
        nuevaRespuesta.appendChild(divLabelRespuesta);

        let divRespuesta = document.createElement('div');
        divRespuesta.className = "col-xs-8 col-sm-8 table-row";
        let inputRespuesta = document.createElement('input');
        inputRespuesta.className = "form-control";
        inputRespuesta.type="text";
        inputRespuesta.placeholder="Texto, URLVideo o URLImágen";
        inputRespuesta.name="pregunta_respuesta_"+i;
        inputRespuesta.value="";
        inputRespuesta.id="form_pregunta_respuesta_"+i;
        divRespuesta.appendChild(inputRespuesta);
        nuevaRespuesta.appendChild(divRespuesta);

        let divPorcentaje = document.createElement('div');
        divPorcentaje.className = "col-xs-2 col-sm-2 table-row";
        let inputPorcentaje = document.createElement('input');
        inputPorcentaje.className = "form-control";
        inputPorcentaje.type="text";
        inputPorcentaje.placeholder="0";
        inputPorcentaje.name="pregunta_respuesta_porcentaje_"+i;
        inputPorcentaje.value="";
        inputPorcentaje.id="form_pregunta_respuesta_porcentaje_"+i;
        divPorcentaje.appendChild(inputPorcentaje);
        nuevaRespuesta.appendChild(divPorcentaje);

        let divLabelPorcentaje = document.createElement('div');
        divLabelPorcentaje.className = "col-xs-1 col-sm-1 table-row";
        let labelP = document.createElement('label');
        labelP.innerHTML = "%";
        labelP.htmlFor = "form_pregunta_respuesta_porcentaje_"+i;
        divLabelPorcentaje.appendChild(labelP);
        nuevaRespuesta.appendChild(divLabelPorcentaje);

        elementoRespuestas.appendChild(nuevaRespuesta);
    }
}

function duplicaPregunta(){
    let submit = document.getElementById("form_guardar_pregunta");
    let elementoDuplicado = document.getElementById("form_pregunta_duplicada");
    elementoDuplicado.value = "duplicada";
    submit.click();
}

// function generarExamen(es_vista_previa) {
//     if(es_vista_previa){
//         alert("vista previa");
//     }
// }
