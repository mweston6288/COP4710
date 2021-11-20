<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo $row["username"]."<br>";
  }
} else {
  echo "0 results";
}

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
	case '/':
        require __DIR__ . '/samples/login.html';
        break;
    case '/admin' :
        require __DIR__ . '/samples/admin.html';
        break;
    case '/signup' :
        require __DIR__ . '/samples/signup.html';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/samples/professor.html';
        break;
}

?>
