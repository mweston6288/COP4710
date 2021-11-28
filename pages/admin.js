var urlBase = "http://localhost:8000/api/";
var adminBase = "admin/";
var professorsBase = "professor/";
var extension = ".php";

document.getElementById('getProfessors').onclick = function(){
  getProfessors()
};

// Populates professors table on admin page.
function getProfessors(){
  console.log("Getting Professors..");
  // Establish endpoint url we will call.
  var url = urlBase + adminBase + "getAllProfessors" + extension;

  console.log(url);
  // Start request
  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

  try{

    // Establish state changes for html request.
    xhr.onreadystatechange = function(){
      // All went well.
      if(this.readyState == 4 && this.status == 200){
        // Parse response.
        var response = JSON.parse(this.response);
        console.log(response);

        // Generate table with response.
        var table = document.getElementById("professorTable");
        // Clear table
        var rowCount = table.rows.length;
				for(var i = 0; i < rowCount; i++)
				{
					table.deleteRow(0);
				}
        
        // Generate Table
        generateTableHead(table);
        response.professors.forEach(element => {
          let row = table.insertRow(); // Create Row
          let cell = row.insertCell(); // Create first cell
          let text = document.createTextNode(element.professorID); // Assign ID
          cell.appendChild(text); // ADD ID

          // Add Name
          cell = row.insertCell();
          text = document.createTextNode(element.name);
          cell.appendChild(text);

          // Add email
          cell = row.insertCell();
          text = document.createTextNode(element.email);
          cell.appendChild(text);
          
          //TODO: Delete button
          cell = row.insertCell();
          text = document.createElement("input");
          text.type = "button";
          text.value = "Delete";
          text.onclick = function(){
            deleteProfessor(element.professorID);
          };
          cell.appendChild(text);

        });
      }else if(xhr.readyState == 4 && xhr.status == 500){ // Something is wrong
        console.log("An error has occured");
      }
    }

    // Send Request
    xhr.send(null);
  }catch(err){
    console.log(err.message);
  }
}

function deleteProfessor(id) {
  console.log(id);

  // Establish endpoint url we will call.
  var url = urlBase + adminBase + "deleteProfessor" + extension;

  if(!confirm("Are you sure you want to delete this professor?")){
    return;
  }

  console.log(url);
  var payload = JSON.stringify({professorID: id});
  console.log(payload);
  // Start request
  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

  try{
    xhr.onreadystatechange = function() {
      // All went well.
      if(this.readyState == 4 && this.status == 204){
        console.log("Successfully deleted professor with ID: " + id);
        getProfessors();
      }else if(this.readyState == 4 && this.status == 404){
        console.log("Something went wrong...");
      }
    }

    xhr.send(payload);
  }catch(e){
    console.log(e.message);
  }
}

function generateTableHead(table) {
	let thead = table.createTHead();
	let row = thead.insertRow();
	let data = ["ID", "Name", "Email"]
	for (let i = 0; i < data.length; i++) {
		let th = document.createElement("th");
		let text = document.createTextNode(data[i]);
		th.appendChild(text);
		row.appendChild(th);
	}
}
