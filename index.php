<?php
$hostname = "localhost";
$username = "root";
$password = "password";
// Create connection
$conn = mysqli_connect($hostname, $username, $password);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$request = $_SERVER['REQUEST_URI'];
$regex = "/\/signup\?id=[0-9]+&email=[A-Za-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[A-Za-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/";
switch ($request) {
	case '/':
    require __DIR__ . '/pages/login.html';
    break;
  case '/admin' :
    require __DIR__ . '/pages/admin.html';
    break;
  case '/professor':
    require __DIR__ . '/pages/professor.html';
    break;
  default:
    if(preg_match($regex, $request)){
      require __DIR__ . '/pages/signup.html';
      break;
    }
    http_response_code(404);
    require __DIR__ . '/pages/login.html';
    break;
}

?>
