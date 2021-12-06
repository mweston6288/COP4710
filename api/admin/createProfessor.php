<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Retrieve the data from the HTTP Request body.
    $data = httpRequest();
    $email = $data['email'];
    $name = $data['name'];
            
    // Query for a table to see if the professor already exists.
    $query = "SELECT * FROM professor WHERE email = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("s", $email);
    $preparedStatement->execute();
    $resultTable = $preparedStatement->get_result();

    // If the professor doesn't exist, insert into to table successfully.
    if ($resultTable->num_rows < 1)
    {
        // Don't create username and password yet.
        // Leave that for the professor to fill in off their email invite.
        $query = "INSERT INTO professor(email, name) VALUES(?, ?)";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param("ss", $email, $name);
        $preparedStatement->execute();

        // Get the id from the last inserted professor.
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
    // Otherwise return HTTP header 400 BAD REQUEST as professor already exists.
    else 
    {
        badRequest();
    }
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>