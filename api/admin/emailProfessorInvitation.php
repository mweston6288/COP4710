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

    $query = "SELECT * FROM professor WHERE profId = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("i", $profId);
    $preparedStatement->execute();
    $resultTable = $preparedStatement->get_result();

    // Get the professor's info and see if they have an account.
    $professors = array();
    if ($resultTable->num_rows > 0)
    {
        $row = $resultTable->fetch_assoc();
        $email = $row['email'];
        $name = $row['name'];
        $hasAccount = trim($row['username']) !== "";
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

    // Send email invitation to the professor.
    $urlQuery = array(
        'profId' => $profId
    );
    $invitationURL = $hasAccount ? "http://localhost/pages/login.html?".http_build_query($urlQuery) : "http://localhost/pages/signup.html?".http_build_query($urlQuery);
    $loginOrSignUp = $hasAccount ? "login" : "signup";
    $emailSubject = "Invitation to request book information.";
    $emailContent = <<<_END
        <p>You are invited to submit your book request information. Please $loginOrSignUp through the following link:</p>
        <p>$invitationURL</p>
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