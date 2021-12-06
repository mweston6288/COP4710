var urlBase = "http://localhost:8000/api/";
var adminBase = "admin/";
var professorsBase = "professor/";
var extension = ".php";
var modal; // declare modal to be used anywhere in file.

var professorButtons = document.getElementById("professorButtons");
var adminButtons = document.getElementById("adminButtons");
var requestButtons = document.getElementById("requestButtons");

// ---------- Professor Stuff ----------
document.getElementById('getProfessors').onclick = function(){
  getProfessors()
};

// Populates professors table on admin page.
function getProfessors(){
  // Set styling
  professorButtons.style.display = "inline";
  adminButtons.style.display = "none";
  requestButtons.style.display="none";

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
        var table = document.getElementById("table");
        // Clear table
        var rowCount = table.rows.length;
				for(var i = 0; i < rowCount; i++)
				{
					table.deleteRow(0);
				}
        
        // Generate Table
        generateTableHead(table, "professor");
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

// Add Professor Form
document.getElementById("submitProf").addEventListener("click", function(event){
  event.preventDefault();
  addProfessor();
})

function addProfessor() {
  var form = Array
    .from(document.querySelectorAll('#addProfForm input'))
    .reduce((acc, input) => ({ ...acc, [input.id]: input.value}), {});

  var payload = JSON.stringify(form);

  // Connection info
  var url = urlBase + adminBase + "createProfessor" + extension;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

  try{
    xhr.onreadystatechange = function () {

      if(this.readyState == 4 && this.status == 201){
        // Reset form
        document.getElementById("name").value = "";
        document.getElementById("email").value = "";

        // Close modal
        closeModal();
      }else if(this.readyState == 4 && this.status == 400){

        //TODO: Add error message to modal.
        console.log("Professor already exists");
      }
    }

    xhr.send(payload)
  }catch(e){
    console.log(e.message);
  }

}

// Push Reminder
function addReminder(){
  // Establish endpoint url we will call.
  var url = urlBase + adminBase + "emailProfessorsOrderDeadline" + extension;
  var date = document.getElementById("date").value;
  console.log(date);
  // Start request
  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
  var payload = `{"deadlineDate": "${date}"}`
  try{

    // Establish state changes for html request.
    xhr.onreadystatechange = function(){
      // All went well.
      if(this.readyState == 4 && this.status == 200){

        alert("Reminder sent");
  
      }else if(xhr.readyState == 4 && xhr.status == 500){ // Something is wrong
        console.log("An error has occured");
      }
    }

    // Send Request
    xhr.send(payload);
  }catch(err){
    console.log(err.message);
  }
}


// --------------- Admin stuff ---------------
function getAdmins(){
  // Set styling
  professorButtons.style.display = "none";
  adminButtons.style.display = "inline";
  requestButtons.style.display = "none";
  
  console.log("Getting Professors..");
  // Establish endpoint url we will call.
  var url = urlBase + adminBase + "getAllAdmins" + extension;

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
        var table = document.getElementById("table");
        // Clear table
        var rowCount = table.rows.length;
				for(var i = 0; i < rowCount; i++)
				{
					table.deleteRow(0);
				}
        
        // Generate Table
        generateTableHead(table, "admin");
        response.admins.forEach(element => {
          let row = table.insertRow(); // Create Row
          let cell = row.insertCell(); // Create first cell
          let text = document.createTextNode(element.adminID); // Assign ID
          cell.appendChild(text); // ADD ID

          // Add Name
          cell = row.insertCell();
          text = document.createTextNode(element.username);
          cell.appendChild(text);

          // Add email
          cell = row.insertCell();
          text = document.createTextNode(element.password);
          cell.appendChild(text);
          
          //TODO: Delete button
          cell = row.insertCell();
          text = document.createElement("input");
          text.type = "button";
          text.value = "Delete";
          text.onclick = function(){
            deleteAdmin(element.adminID);
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

// Delete Admin
function deleteAdmin(id) {
  console.log(id);

  // Establish endpoint url we will call.
  var url = urlBase + adminBase + "deleteAdmin" + extension;

  if(!confirm("Are you sure you want to delete this admin?")){
    return;
  }

  console.log(url);
  var payload = JSON.stringify({adminID: id});
  console.log(payload);
  // Start request
  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

  try{
    xhr.onreadystatechange = function() {
      // All went well.
      if(this.readyState == 4 && this.status == 204){
        console.log("Successfully deleted admin with ID: " + id);
        getAdmins();
      }else if(this.readyState == 4 && this.status == 404){
        console.log("Something went wrong...");
      }
    }

    xhr.send(payload);
  }catch(e){
    console.log(e.message);
  }
}


document.getElementById("submitAdmin").addEventListener("click", function(event){
  event.preventDefault();
  addAdmin();
})

// Add Admin
function addAdmin() {  
  var form = Array
    .from(document.querySelectorAll('#addAdminForm input'))
    .reduce((acc, input) => ({ ...acc, [input.id]: input.value}), {});

  var payload = JSON.stringify(form);

  // Connection info
  var url = urlBase + adminBase + "registerAdmin" + extension;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

  try{
    xhr.onreadystatechange = function () {

      if(this.readyState == 4 && this.status == 201){
        // Reset form
        document.getElementById("username").value = "";
        document.getElementById("password").value = "";

        // Close modal
        closeModal();
      }else if(this.readyState == 4 && this.status == 400){

        //TODO: Add error message to modal.
        console.log("Admin already exists");
      }
    }

    xhr.send(payload)
  }catch(e){
    console.log(e.message);
  }

}
document.getElementById("submitReminder").addEventListener("click", function(event){
  event.preventDefault();
  addReminder();
})

// --------------- Request stuff ---------------
var select = document.getElementById("selectSemester");
select.addEventListener("change", function(event){
  event.preventDefault();
  getAllBookRequests(select.value);
})

function loadBookRequests() {
  // Set styling
  professorButtons.style.display = "none";
  adminButtons.style.display = "none";
  requestButtons.style.display = "inline";

  var select = document.getElementById("selectSemester");

  var url = urlBase + adminBase + "getAllExistingSemesters" + extension;
  var xhr = new XMLHttpRequest();
  xhr.open("GET", url, true);
  xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

  try{
    xhr.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200){
        var response = JSON.parse(this.responseText);

        response.semesters.forEach((element) => {
          var option = document.createElement("option");
          option.value = element;
          option.text = element;

          select.add(option);
        })
      }
    }

    xhr.send(null);
  }catch(e){
    console.log(e.message);
  }
}

function getAllBookRequests() {
  var semester = document.getElementById("selectSemester").value;

  var payload = JSON.stringify({semester});

  var url = urlBase + adminBase + "getAllBookRequestsForSemester" + extension;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

  try{
    xhr.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200){
        var response = JSON.parse(this.responseText);

        // Generate table with response.
        var table = document.getElementById("table");
        // Clear table
        var rowCount = table.rows.length;
				for(var i = 0; i < rowCount; i++)
				{
					table.deleteRow(0);
				}
        
        // Generate Table
        generateTableHead(table, "request");
        response.requests.forEach(element => {
          let row = table.insertRow(); // Create Row
          let cell = row.insertCell(); // Create first cell
          let text = document.createTextNode(element.name); // Assign name
          cell.appendChild(text); // ADD name

          // Add professorID
          cell = row.insertCell();
          text = document.createTextNode(element.profId);
          cell.appendChild(text);

          // Add number of books
          cell = row.insertCell();
          text = document.createTextNode(element.bookAmount);
          cell.appendChild(text);
        });
      }
    }

    xhr.send(payload);
  }catch(e){
    console.log(e.message);
  }

}

function getFinalRequests() {
  var semester = "Fall 2021";
  var payload = JSON.stringify({semester});

  var url = urlBase + adminBase + "getFinalBookRequestsForSemester" + extension;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

  try{
    xhr.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200){
        var response = JSON.parse(this.responseText);

        console.log(response);
      }
    }

    xhr.send(null);
  }catch(e){
    console.log(e.message);
  }

}


// Table Generation
function generateTableHead(table, name) {
	let thead = table.createTHead();
	let row = thead.insertRow();
	let data;
  
  switch(name){
    case 'admin':
      data = ["ID","Username","Password"];
      break;
    case 'professor':
      data = ["ID", "Name", "Email"];
      break;
    case 'request':
      data = ["Professor", "ID", "Books"];
  }

	for (let i = 0; i < data.length; i++) {
		let th = document.createElement("th");
		let text = document.createTextNode(data[i]);
		th.appendChild(text);
		row.appendChild(th);
	}
}

// Modal STUFF
function closeModal(){
  modal.style.display = "none";

  modal = null;
}

function openModal(id) {
  modal = document.getElementById(id);

  modal.style.display = "block";
}

window.onclick = function(event) {
  if(event.target == modal){
    closeModal();
  }
}