<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';
    require_once '../utility/phpMailer.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();
            
    // Retrieve the deadline date from the HTTP Request body.
    $data = httpRequest();
    $profId = $data['profId'];
    
    // Get random password.
    $length = 10;    
    $tempPassword = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $length);

    // Update DB with temp password.
    $query = "UPDATE professor SET password = ? WHERE profId = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("si", $tempPassword, $profId);
    $preparedStatement->execute();
    $resultTable = $preparedStatement->get_result();

    // Get professor info and send email about temporary password.
    $query = "SELECT * FROM professor WHERE profId = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("i", $profId);
    $preparedStatement->execute();
    $resultTable = $preparedStatement->get_result();

    $professors = array();
    if ($resultTable->num_rows > 0)
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
    else
    {
        // Professor doesn't exist
        badRequest();
    }

    // Send temp password email to professor.
    $emailSubject = "Requested temporary password.";
    $emailContent = <<<_END
        <p>The temporary password for your account is: $tempPassword</p>
        <p><br></p>
        <p>Thank you,</p>
        <p>COP4710 Bookstore</p>
        _END;

    if (sendEmail($professors, $emailSubject, $emailContent))
    {
        // Successful request 200 OK
        ok();
    }
    else
    {
        // Unsuccessful request 400 bad request
        badRequest();
    }
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>