<?php
    require_once './utility/dbLogin.php';
    require_once './utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Retrieve the data from the HTTP Request body.
    $data = httpRequest();
    $username = $data['username'];
    $password = $data['password'];
            
    // Query for a table to see if the user/pass already exists.
    $query = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("ss", $username, $password);
    $preparedStatement->execute();
    $resultTable = $preparedStatement->get_result();

    // If the user doesn't exist, insert into to table successfully.
    if ($resultTable->num_rows < 1)
    {
        $query = "INSERT INTO users(username, password) VALUES(?, ?)";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param("ss", $username, $password);
        $preparedStatement->execute();

        // Returns HTTP header 201 CREATED
        created();
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