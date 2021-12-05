



function getCookie(){
	// Split cookie string
    var cookieArr = document.cookie.split(",");
    // Get the second element which is the id
    var cookiePair = cookieArr[1].split("=");

	// return id value
    return decodeURIComponent(cookiePair[1]);

}



function submit (){

  var ProfessorID=document.getElementById("ProfessorID").value;
  var newPassword=document.getElementById("newPassword").value;


	var profId = getCookie();

	var url = 'http://localhost:8000/api/professor/changeProfPassword.php'

	var payload = {};
	payload.ProfessorID = ProfessorID;

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
