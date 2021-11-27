<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';
    require_once '../utility/phpMailer.php';

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
    $professors = array();
    for ($i = 0; $i < $resultTable->num_rows; $i++)
    {
        $row = $resultTable->fetch_assoc();
        $email = $row['email'];
        $name = $row['name'];
        $professor = array(
            'email' => $email,
            'name' => $name
        );

        array_push($professors, $professor);
    }

    // Send email to all professors.
    if (sendEmail($professors, "test", "my testssss"))
    {
        echo "success";
    }
    else
    {
        echo "fail";
    }
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>