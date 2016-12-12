
function deleteSchool(id){

    console.log(id);
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "DELETE", 'http://localhost/QMVC/home/'+id, false ); // false for synchronous request
    xmlHttp.send( null );
    return xmlHttp.responseText;
}

function updateSchool(id){

    console.log(id);
    var name = document.getElementsByName('Name')[0].value;
    var address = document.getElementsByName('Address')[0].value;
    var telephone = document.getElementsByName('Telephone')[0].value;
    var principal = document.getElementsByName('Principal')[0].value;
    var requestBody = JSON.stringify({"Name": name, "Address": address, "Telephone": telephone, "Principal": principal});
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "PUT", 'http://localhost/QMVC/home/'+id, false ); // false for synchronous request
    xmlHttp.setRequestHeader("Content-Type", "application/json");
  //  console.log(xmlHttp);
    xmlHttp.send(requestBody);
    console.log(xmlHttp.response);
}