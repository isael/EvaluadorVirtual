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
    resultados = document.getElementById(results.id);
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

function updateResponse(results, textElement, text){
    element = document.getElementById(textElement.id);
    element.value = text;
    toogleSelector(results);
}
