// Declare fields.
var id;
var username;
var profName;

function handleLogin(){
	id=0;
	username="";
	profName="";

  var user=document.getElementById("username").value;
	var password=document.getElementById("password").value;
	var type=document.getElementById("type").value;

  var url = 'http://localhost:8000/api/login/';
  
	if (type === "admin")
		url += "adminLogin.php";
	else{
		url += "professorLogin.php";
	}

    // Prepare the values for HTTP request in JSON.
    var payload = `{"username" : "${user}", "password" : "${password}"}`;
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
                // Grab fields passed from HTTP Response body to local fields.
				var jsonObject = JSON.parse(xhr.responseText);
				
                // Change page to appropriate page.
				if (type === "admin"){
					id = jsonObject.id;
					username = jsonObject.username;
					saveCookie()
					window.location.href = "/admin";
				}
				else{
					id = jsonObject.id;
					username = jsonObject.username;
					profName = jsonObject.name;
					saveCookie()
					window.location.href = "/professor";
				}

			}
            // If the response header is 400 Bad Request, signal user doesn't exist.
            else if (this.readyState == 4 && this.status == 400)
            {

                alert("Username or password does not exist!");

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
	document.cookie = "name=loginCookie,id=" + id + ",username=" + username + ",profName=" + encodeURIComponent(profName) + ",expires=" + date.toUTCString()+",SameSite=Lax";
}

function showPasswordReset(){
	document.getElementById("forgot").innerHTML = `
	<div>
    <label> Your name
    <input type = "text" id= "name">
    </label>
    </div>
	<div>
    <label> Your email
    <input type = "text" id= "profEmail">
    </label>
    </div>
	<button type= "submit" onclick = "passwordChange()">  Submit</button>
	`
}
function passwordChange(){

		var name=document.getElementById("name").value;
		var email=document.getElementById("email").value;
	  
	  
	  
		  var url = 'http://localhost:8000/api/professor/changeProfPassword.php'
	  
		  var payload = {};
		  payload.name = name;
	  	payload.email = email;
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