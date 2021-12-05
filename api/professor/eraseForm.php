<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Retrieve the data from the HTTP Request body.
    $data = httpRequest();
    $profId = $data['profId'];

    // delet all requests for a given professor.
    $query = "DELETE FROM request WHERE profId = ?;";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("i", $profId);
    $preparedStatement->execute();
    // Check if any errors occur.
    if ($preparedStatement->errno == 0)
    {
        // Return status code 200.
        ok();
    }
    // Otherwise, professor has no entries. Return status code 400 BAD REQUEST. 
    else 
    {
        badRequest();
    }   
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>