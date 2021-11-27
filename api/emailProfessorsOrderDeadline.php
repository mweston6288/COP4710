<?php
    require_once './utility/dbLogin.php';
    require_once './utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();
            
    // Retrieve the deadline date from the HTTP Request body.
    $data = httpRequest();
    $deadlineDate = $data['deadlineDate'];

    $query = "SELECT * FROM professor";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->execute();
    $resultTable = $preparedStatement->get_result();

    // Iterate through all the professor emails and append to the emails array.
    $emails = array();
    for ($i = 0; $i < $resultTable->num_rows; $i++)
    {
        $row = $resultTable->fetch_assoc();
        $email = $row['email'];

        array_push($emails, $email);
    }

    
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>