<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Retrieve the data from the HTTP Request body.
    $data = httpRequest();
    $username = $data['username'];
    $password = $data['password'];
            
    // Query for a table to see if the user/pass already exists.
    $query = "INSERT INTO admin(username, password) VALUES(?, ?)";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("ss", $username, $password);
    $preparedStatement->execute();

    // If the user doesn't exist, insert into to table successfully.
    if ($conn->affected_rows > 0)
    {
        // Get the id from the last inserted admin.
        $query = "SELECT LAST_INSERT_ID()";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->execute();
        $resultTable = $preparedStatement->get_result();
        
        $createdId = 0;
        if ($resultTable->num_rows > 0)
        {
            $row = $resultTable->fetch_assoc();
            $createdId = $row['LAST_INSERT_ID()'];
        }

        $data = array(
            'createdId' => $createdId
        );

        // Returns HTTP header 201 CREATED
        created();
        header("Content-Type: application/json");
        httpResponse($data);
    }
    // Otherwise return HTTP header 400 BAD REQUEST as user already exists.
    else 
    {
        badRequest();
    }
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>