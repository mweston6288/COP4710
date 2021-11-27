// Declare fields.
var id;
var username;
var profName;

function attemptRegister(){
	id=0;
	username="";
	profName="";

  	var user=document.getElementById("username").value;
	var password=document.getElementById("password").value;
	var confirm=document.getElementById("confirm").value;

	var url = 'http://localhost:8000/api/signup/profSignup.php';
  
	if (password !== confirm){
		document.getElementById("error").innerHTML = "passwords do not match"
		return;
	}


	const params = new URLSearchParams(window.location.search);
    // Prepare the values for HTTP request in JSON.
    var payload = `{"username" : "${user}", "password" : "${password}", "id" : "${params.get("id")}"}`;
    var xhr = new XMLHttpRequest();
    // Create JSON HTTP Request destination.
    try{

		xhr.open("PUT", url, true);
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
                // Grab fields passed from HTTP Response body to local fields.
				var jsonObject = JSON.parse(xhr.responseText);
				
                // Change page to appropriate page.

				id = jsonObject.id;
				username = jsonObject.username;
				profName = jsonObject.name;
				saveCookie()
				window.location.href = "/professor";


			}
            // If the response header is 400 Bad Request, signal user doesn't exist.
            else if (this.readyState == 4 && this.status == 400)
            {

                alert("Account already exists!");

            }
		};
		xhr.send(payload);
	}
	catch (err)
	{
		alert(err.message);
	}
}

// Cookie holds onto user info and expires in 20 minutes.
function saveCookie()
{
	var minutes = 20;
	var date = new Date();
	date.setTime(date.getTime() + (minutes*60*1000));	
	document.cookie = "name=loginCookie, username=" + username + ",profName=" + profName + ",id=" + id + ";expires=" + date.toUTCString()+", SameSite=Lax";
}