<?php 
  include '../dbLogin.php';
  include '../httpPackage.php';
  
  // Establish conneciton to DB.
  $server = new Server();
  $conn = $server->connect();

  // Get data
  $data = httpRequest();
  $username = $data['username'];
  $password = $data['password'];

  // Setup query
  if($username !='' && $password != ''){
    $stmt = $conn->prepare("SELECT username FROM admin WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows < 1){
      $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
      $stmt->bind_param("ss", $username, $password);
      $stmt->execute();
      $result = $stmt->get_result();

      if($result->numRows < 1){
        badRequest();
      }

      created();

    }else{
      badRequest();
    }
  }else{
    badRequest();
  }

  $stmt->close();
  $conn->close();
?>