<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';
	require_once '../utility/phpMailer.php';

	// Connect to database.
	$server = new Server();
	$conn = $server->connect();

	// Retrieve the data from the HTTP Request body.
	$data = httpRequest();
	$username = $data['username'];
	$email = $data['email'];
	$str=substr(md5(rand()),0,6);
	// Change professor password with given id.
	$query = "UPDATE professor SET password = ? WHERE email = ? AND username IS NOT NULL AND username = ?";
	$preparedStatement = $conn->prepare($query);
	$preparedStatement->bind_param("sss", $str, $email, $username);
	$preparedStatement->execute();
	$preparedStatement->store_result();
    if ($conn->affected_rows > 0){
		
	    $emailSubject = "password change request";
    	$emailContent = <<<_END
			<p>You resently requested a password change.</p>
			<p>Your new password is <strong>$str</strong></p>
			<p><br></p>
			<p>Thank you,</p>
			<p>COP4710 Bookstore</p>
			_END;

    	if (emailPassword($email, $username, $emailSubject, $emailContent))
    	{
        	// Successful request 200 OK
			noContent();
   	 	}	
		else
			badRequest();

	}
	else
		badRequest();

	// Close the database at end of script
	$preparedStatement->close();
	$conn->close();
	exit;
?>
