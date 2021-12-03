
function submit (){




var bookTitle = document.getElementById ("bookTitle").value
var AuthorNames = document.getElementById ("AuthorNames").value
var Edition = document.getElementById ("Edition").value
var Publisher = document.getElementById ("Publisher").value
var ISBN = document.getElementById ("ISBN").value
var Semester = document.getElementById ("Semester").value


var url = 'http://localhost:8000/api/professor/requestBook.php'

var payload = `{"profID" : "${}", "ISBN" : "${ISBN}", "Semester": "${Semester}"}`







}
