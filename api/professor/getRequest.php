<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Retrieve the data from the HTTP Request body.
    $data = httpRequest();
	$profId = $data['profId'];

    // Prepared statement (security) to retrieve row.
    $query = "SELECT request.requestId, request.semester, book.ISBN, book.bookTitle, book.author, book.edition, book.publisher FROM request LEFT JOIN book ON request.ISBN = book.ISBN WHERE request.profId = ?";
  	$preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("i", $profId);
    $preparedStatement->execute();

    $resultTable = $preparedStatement->get_result();
    // If the user row/table exists or not.
    if ($resultTable->num_rows > 0)
    {
		$request = array();
        // Create JSON of existing row.
        while($row = $resultTable->fetch_assoc()){
			$request[]=$row;
		}

        // Return status code 200 and JSON of this existing user row/object.
        ok();
        header("Content-Type: application/json");
        httpResponse($request);
    }
    // Otherwise, user doesn't exist. Return status code 400 BAD REQUEST. 
    else 
    {
        badRequest();
		httpResponse($data);

    }   
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>