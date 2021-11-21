<?php 

  include '../dbLogin.php';
  include '../httpPackage.php';
  
  // Establish conneciton to DB.
  $server = new Server();
  $conn = $server->connect();

  // Get request data
  $data = httpRequest();
  $user = $data['search'];

  $user = "%" . $user . "%";

  // Setup query
  $stmt = $conn->prepare("SELECT username FROM admin WHERE username LIKE ?");
  $stmt->bind_param("s", $user);
  $execResult = $stmt->execute();

  if( false===$execResult ){
    returnError( $stmt->error );
  }

  $result = $stmt->get_result();
  $searchResult = array();
  $searchCount = 0;

  while($row = $result->fetch_assoc()){
    array_push($searchResult, $row);
    $searchCount++; 
  }

  if($searchCount == 0){
    notFound();
  }else{
    httpResponse($searchResult);
  }

  $stmt->close();
  $conn->close();
?>