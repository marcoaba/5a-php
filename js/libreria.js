function sendRequest(url,method,parameters,callback){
    $.ajax({
        url: url,
        type: method,
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        dataType: "text",
        data: parameters,
        timeout : 6000000,
        success: callback,
        error : function(jqXHR, test_status, str_error){
            alert("Error: " + str_error);
        }
    });
}

function sendRequestNoCallback(url,method,parameters){
    return $.ajax({
        url: url,
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        //contentType:"application/json",
        type: method,
        dataType: "json",
        data: parameters,
        timeout: 5000
    });
}

function error(jqXHR, testStatus, strError) {
    if (jqXHR.status == 0)
        console.log("server timeout");
    else if (jqXHR.status == 200)
        console.log("Formato dei dati non corretto : " + jqXHR.responseText);
    else
        console.log("Server Error: " + jqXHR.status + " - " + jqXHR.responseText);
}