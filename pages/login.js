var url = 'http://localhost:8000/api/login/';

function handleLogin(){

	var username=document.getElementById("username").value;
	var password=document.getElementById("password").value;
	var type=document.getElementById("type").value;
	
	if (type === "admin")
		url += "adminGet.php";
	else{
		url += "professorGet.php";
	}
	console.log(typeof url)
    // Prepare the values for HTTP request in JSON.
    var payload = `{"username" : "${username}", "password" : "${password}"}`;
    var xhr = new XMLHttpRequest();
    // Create JSON HTTP Request destination.
    try{

		xhr.open("POST", url, true);
	}catch (e){
		console.error(e);
	}
	console.log(xhr);
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
                // Grab fields passed from HTTP Response body to local fields.
				var jsonObject = JSON.parse(xhr.responseText);
				console.log(jsonObject)

                // Change page to appropriate page.
				if (type === "admin")
					window.location.href = "/admin";
				else
					window.location.href = "/professor";

			}
            // If the response header is 400 Bad Request, signal user doesn't exist.
            else if (this.readyState == 4 && this.status == 400)
            {

                alert("Username or password does not exist!");
				window.location.href = "/";

            }
		};
		xhr.send(payload);
	}
	catch (err)
	{
		alert(err.message);
	}
}