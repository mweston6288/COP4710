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

    // Prepared statement (security) to retrieve row.
    $query = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("ss", $username, $password);
    $preparedStatement->execute();
    $resultTable = $preparedStatement->get_result();
    
    // If the user row/table exists or not.
    if ($resultTable->num_rows > 0)
    {
        // Create JSON of existing row.
        $row = $resultTable->fetch_assoc();
        $id = $row['adminId'];
        $username = $row['username'];
        $password = $row['password'];

        $user = array(
            'adminID' => $id,
            'username' => $username,
            'password' => $password
        );

        // Return status code 200 and JSON of this existing user row/object.
        ok();
        header("Content-Type: application/json");
        httpResponse($user);
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