<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Retrieve the data from the HTTP Request body.
    $data = httpRequest();
	$profId = $data['profId'];

    // Retrieve all professor requests from request joined with their matching data in book.
    $query = "SELECT request.requestId, request.semester, book.ISBN, book.bookTitle, book.author, book.edition, book.publisher FROM request LEFT JOIN book ON request.ISBN = book.ISBN WHERE request.profId = ?";
  	$preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("i", $profId);
    $preparedStatement->execute();

    $resultTable = $preparedStatement->get_result();
    // If anything exists.
    if ($resultTable->num_rows > 0)
    {
		$request = array();
        // Create JSON of existing rows.
        while($row = $resultTable->fetch_assoc()){
			$request[]=$row;
		}

        // Return status code 200 and JSON of all entries.
        ok();
        header("Content-Type: application/json");
        httpResponse($request);
    }
    // Otherwise, professor has no requests. Return status code 400 BAD REQUEST. 
    else 
    {
        badRequest();
    }   
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>