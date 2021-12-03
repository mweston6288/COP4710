<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Retrieve the data from the HTTP Request body.
    $data = httpRequest();
    $profId = $data['profId'];

    // Prepared statement (security) to retrieve row.
    $query = "DELETE FROM request WHERE profId = ?;";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("i", $profId);
    $preparedStatement->execute();
    // If the user row/table exists or not.
    if ($preparedStatement->errno == 0)
    {
        // Return status code 200 and JSON of this existing user row/object.
        ok();
    }
    // Otherwise, user doesn't exist. Return status code 400 BAD REQUEST. 
    else 
    {
        badRequest();
    }   
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>