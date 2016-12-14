
function deleteSchool(id){

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "DELETE", window.location.href + '/' + id, false ); // false for synchronous request
    xmlHttp.send( null );
    location.reload();
}

function createSchool(){

    var name = document.getElementById('newName').value;
    var address = document.getElementById('newAddress').value;
    var telephone = document.getElementById('newTelephone').value;
    var requestBody = JSON.stringify({"Name": name, "Address": address, "Telephone": telephone});
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "POST", Window.location.href, false ); // false for synchronous request
    xmlHttp.setRequestHeader("Content-Type", "application/json");
    xmlHttp.send(requestBody);
    location.reload();
}

function updateSchool(id){

    var name = document.getElementById(id+'Name').value;
    var address = document.getElementById(id+'Address').value;
    var telephone = document.getElementById(id+'Telephone').value;
    var requestBody = JSON.stringify({"Name": name, "Address": address, "Telephone": telephone});
    console.log(requestBody);
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "PUT", window.location.href + '/' + id, false ); // false for synchronous request
    xmlHttp.setRequestHeader("Content-Type", "application/json");
    xmlHttp.send(requestBody);
    location.reload();
}