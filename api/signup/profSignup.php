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
	$id = $data['id'];

    // Update the professor with a username and password.
    $query = "UPDATE professor SET username= ?, password = ? WHERE profId = ?;";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("ssi", $username, $password, $id);
    $preparedStatement->execute();
    // If no issues return professor.
    if ($preparedStatement->errno == 0)
    {
		// get professor info and send it back
        $newQuery = "SELECT profId, username, name FROM professor WHERE username = ?;";
		$stmt = $conn->prepare($newQuery);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$resultTable = $stmt->get_result();

        // Create JSON of existing row.
        $row = $resultTable->fetch_assoc();
        $id = $row['profId'];
        $username = $row['username'];
		$name = $row['name'];
        $user = array(
            'id' => $id,
            'username' => $username,
			'name' => $name
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