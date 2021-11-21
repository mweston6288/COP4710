<?php 

  include '../dbLogin.php';
  include '../httpPackage.php';
  
  // Establish conneciton to DB.
  $server = new Server();
  $conn = $server->connect();

  // Setup query
  $stmt = $conn->prepare("SELECT username FROM admin");
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