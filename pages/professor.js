function newForm(){
	document.getElementById("requests").innerHTML="";
	document.getElementById("form").hidden = false;
	var profId = getCookie();

	var url = 'http://localhost:8000/api/professor/eraseForm.php';

    // Prepare the values for HTTP request in JSON.
    var payload = `{"profId" : "${profId}"}`;
    var xhr = new XMLHttpRequest();
    // Create JSON HTTP Request destination.
    try{

		xhr.open("DELETE", url, true);
	}catch (e){
		console.error(e);
	}
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	
    try
	{
		// This event fires anytime the readstate changes (opening HTTP Request, sending HTTP Request, etc).
		xhr.onreadystatechange = function() 
		{

			// If the ready state so happens to be 4 (4 = request finished, response is ready), 
            // and the status code of the HTTP Response for this Request is 200 OK.
			if (this.readyState == 4 && this.status == 200) 
			{
                
                alert("Request form has been reset!");

			}
            // If the response header is 400 Bad Request, signal user doesn't exist.
            else if (this.readyState == 4 && this.status == 400)
            {

                alert("An error has occurred!");

            }
		};
		xhr.send(payload);
	}
	catch (err)
	{
		alert(err.message);
	}
}
function getRequests(){
	document.getElementById("form").hidden = false;


  var url = 'http://localhost:8000/api/professor/getRequest.php';
  var profId = getCookie();

    // Prepare the values for HTTP request in JSON.
    var payload = `{"profId" : "${profId}"}`;
    var xhr = new XMLHttpRequest();
    // Create JSON HTTP Request destination.
    try{

		xhr.open("POST", url, true);
	}catch (e){
		console.error(e);
	}
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	
    try
	{
		// This event fires anytime the readstate changes (opening HTTP Request, sending HTTP Request, etc).
		xhr.onreadystatechange = function() 
		{

			// If the ready state so happens to be 4 (4 = request finished, response is ready), 
            // and the status code of the HTTP Response for this Request is 200 OK.
			if (this.readyState == 4 && this.status == 200) 
			{
                var list = document.getElementById("requests");
				list.innerHTML="";
				// Grab fields passed from HTTP Response body to local fields.
				var jsonObject = JSON.parse(xhr.responseText);
				console.log(jsonObject);
				jsonObject.map(function f(object){
					var child = document.createElement('div');
					child.id = object.requestId;
					child.innerHTML=
					`
					<div>
					<param>
					Title: ${object.bookTitle}
					</param><br/>
					<param>
					Authors: ${object.author}
					</param><br/>
					<param>
					Edition: ${object.edition}
					</param><br/>
					<param>
					Publisher: ${object.publisher}
					</param><br/>
					<param id="ISBN${object.requestId}" value="${object.ISBN}">
					ISBN: ${object.ISBN}
					</param><br/>
					<param id="semester${object.requestId}" value="${object.semester}">
					Semester: ${object.semester}
					</param><br/>
					</div>
					<button onClick="deleteBook(this.parentElement)" value="${child.id}">Remove from list</button>
					<br/><br/>`
					list.appendChild(child);
				})

			}
            // If the response header is 400 Bad Request, signal user doesn't exist.
            else if (this.readyState == 4 && this.status == 400)
            {

                alert("Nothing to display");

            }
		};
		xhr.send(payload);
	}
	catch (err)
	{
		alert(err.message);

	}
}

function getCookie(){
	// Split cookie string
    var cookieArr = document.cookie.split(",");
    // Get the second element which is the id
    var cookiePair = cookieArr[1].split("=");
        
	// return id value
    return decodeURIComponent(cookiePair[1]);

}

function deleteBook(parent){
	var profId = getCookie();
	var semester = document.getElementById(`semester${parent.id}`).value;
	var ISBN = document.getElementById(`ISBN${parent.id}`).value;
	var url = 'http://localhost:8000/api/professor/eraseRequest.php';

    // Prepare the values for HTTP request in JSON.
    var payload = `{"profId" : "${profId}", "semester":"${semester}","ISBN":"${ISBN}"}`;
    var xhr = new XMLHttpRequest();
    // Create JSON HTTP Request destination.
    try{

		xhr.open("DELETE", url, true);
	}catch (e){
		console.error(e);
	}
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	
    try
	{
		// This event fires anytime the readstate changes (opening HTTP Request, sending HTTP Request, etc).
		xhr.onreadystatechange = function() 
		{

			// If the ready state so happens to be 4 (4 = request finished, response is ready), 
            // and the status code of the HTTP Response for this Request is 200 OK.
			if (this.readyState == 4 && this.status == 200) 
			{
                
                parent.remove();

			}
            // If the response header is 400 Bad Request, signal user doesn't exist.
            else if (this.readyState == 4 && this.status == 400)
            {

                alert("An error has occurred!");

            }
		};
		xhr.send(payload);
	}
	catch (err)
	{
		alert(err.message);
	}}

function submit (){




	var bookTitle = document.getElementById ("bookTitle").value
	var ISBN = document.getElementById ("ISBN").value
	var Semester = document.getElementById ("Semester").value
	var profId = getCookie();
	var author = document.getElementById ("AuthorNames").value
	var Edition = document.getElementById ("Edition").value
	var Publisher = document.getElementById ("Publisher").value
	var url = 'http://localhost:8000/api/professor/requestBook.php'

	var payload = {};
	payload.profId = profId;
	payload.ISBN = ISBN, 
	payload.semester= Semester, 
	payload.bookTitle= bookTitle, 
	payload.author= author,
	payload.edition= Edition,
	payload.publisher= Publisher
	fetch(url, {
		method: "POST",
		mode: "same-origin",
		credentials: "same-origin",
		headers: {
		  "Content-Type": "application/json"
		},
		body: JSON.stringify(payload)
	  }).then(function(res){
		  console.log(res);
		  getRequests();
	  })


}
