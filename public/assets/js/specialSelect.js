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
    toogleSelector(textElement, results);
}

function agregarNuevoElementoEnLista(modalInputId,resultsId,responseTextId,cancelButtonId){
    let cancelButton = document.getElementById(cancelButtonId.id);
    let responseText = document.getElementById(responseTextId.id);
    let text = document.getElementById(modalInputId.id).value;
    debugger;
    if(typeof text === 'string' && text !== ''){
        let element = document.getElementById(resultsId.id);
        let li = document.createElement("li");
        let anchor = document.createElement("a");
        anchor.setAttribute('href',"javascript:updateResponse('"+text+"',"+resultsId.id+","+responseTextId.id+",'"+text+"')");
        anchor.innerHTML = text;
        li.appendChild(anchor);
        element.insertBefore(li,element.firstChild);
        cancelButton.click();
        responseText.focus();
    }else{
        //TODO javascript error message
    }
}