function newForm(){
	document.getElementById("form").hidden = !(document.getElementById("form").hidden);
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

function getCookie(){
	// Split cookie string
    var cookieArr = document.cookie.split(",");
    // Get the second element which is the id
    var cookiePair = cookieArr[1].split("=");
        
	// return id value
    return decodeURIComponent(cookiePair[1]);

}

function submit (){




	var bookTitle = document.getElementById ("bookTitle").value
	var AuthorNames = document.getElementById ("AuthorNames").value
	var Edition = document.getElementById ("Edition").value
	var Publisher = document.getElementById ("Publisher").value
	var ISBN = document.getElementById ("ISBN").value
	var Semester = document.getElementById ("Semester").value


	var url = 'http://localhost:8000/api/professor/requestBook.php'

	var payload = `{"profID" : "", "ISBN" : "${ISBN}", "Semester": "${Semester}"}`







}
