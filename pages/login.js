// Declare fields.
var id;
var username;
var profName;

// handle login process
function handleLogin(){
	id=0;
	username="";
	profName="";

	var user=document.getElementById("username").value;
	var password=document.getElementById("password").value;
	var type=document.getElementById("type").value;

	var url = 'http://localhost:8000/api/login/';
	// make php url based on if an admin or professor is logging in
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
				
                // Change page to appropriate page and make login cookie.
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
// if professor forgot their email, show this form so they can request a change
function showPasswordReset(){
	document.getElementById("reset").innerHTML = `
	<div>
    <label> username
    <input type = "text" id= "user">
    </label>
    </div>
	<div>
    <label> Your email
    <input type = "text" id= "profEmail">
    </label>
    </div>
	<button onclick="passwordChange()">  Submit</button>
	`
}
// change password on request
function passwordChange(){
	// password change is not manual. Professor must confirm username and email first.
	var username=document.getElementById("user").value;
	var email=document.getElementById("profEmail").value;	  
	var url = 'http://localhost:8000/api/login/requestNewPassword.php'

    // Prepare the values for HTTP request in JSON.
    var payload = `{"username" : "${username}", "email" : "${email}"}`;
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
			if (this.readyState == 4 && this.status == 204) 
			{
                alert("Check your email for a new password");
			}
            // If the response header is 400 Bad Request, signal user doesn't exist.
            else if (this.readyState == 4 && this.status == 400)
            {

                alert("Username or email is incorrect");

            }
		};
		xhr.send(payload);
	}
	catch (err)
	{
		alert(err.message);
	}
}