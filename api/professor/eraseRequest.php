<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Retrieve the data from the HTTP Request body.
    $data = httpRequest();
    $profId = $data['profId'];
	$ISBN = $data['ISBN'];
	$semester = $data['semester'];

    // Get specific request entry.
    $query = "DELETE FROM request WHERE profId = ? AND ISBN = ? AND semester = ?;";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("iis", $profId, $ISBN, $semester);
    $preparedStatement->execute();
    // If an element was deleted.
    if ($preparedStatement->errno == 0)
    {
        // Return status code 200.
        ok();
    }
    // Otherwise, return status code 400 BAD REQUEST. 
    else 
    {
        badRequest();
    }   
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>