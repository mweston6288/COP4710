<?php
  // server and router file
  require_once './api/utility/dbLogin.php';

  // Create connection
  $server = new Server();
  $conn = $server->connect();
  // Check connection
  if (!$conn) {
    die("Connection failed: ");
  }

  $request = $_SERVER['REQUEST_URI'];
  // regex for the signup page
  // signup url should look like:
  // /signup?id=1
  $regex = "/\/signup\?profId=[0-9]+/";
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
      // check if the request matches the signup regex
      if(preg_match($regex, $request)){
        // check if professor already has an account by chgecking if username is null
        $query = "SELECT * FROM professor WHERE profId = ? AND username='';";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param("i", $_GET['profId']);
        $preparedStatement->execute();
        $resultTable = $preparedStatement->get_result();
        // if found username is null, go to signup page
        if ($resultTable->num_rows > 0){
          require __DIR__ . '/pages/signup.html';
          break;
        }
        // else go to login page
        require __DIR__ . '/pages/login.html';
        break;
      }
    http_response_code(404);
    require __DIR__ . '/pages/login.html';
    break;
  }

?>
