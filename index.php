<?php
    require_once './api/utility/dbLogin.php';

// Create connection
$server = new Server();
$conn = $server->connect();
// Check connection
if (!$conn) {
  die("Connection failed: ");
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
      $query = "SELECT * FROM professor WHERE profId = ? AND username IS NULL;";
      $preparedStatement = $conn->prepare($query);
      $preparedStatement->bind_param("i", $_GET['id']);
      $preparedStatement->execute();
      $resultTable = $preparedStatement->get_result();
      if ($resultTable->num_rows > 0){
        require __DIR__ . '/pages/signup.html';
        break;
      }
      require __DIR__ . '/pages/login.html';
      break;
    }
    http_response_code(404);
    require __DIR__ . '/pages/login.html';
    break;
}

?>
