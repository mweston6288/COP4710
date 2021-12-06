<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Retrieve the data from the HTTP Request body.
    $_POST = httpRequest();
    if($_POST == null){
        noContent();
		header("Content-Type: application/json");
        httpResponse($_POST);        
    }
    $profId = $_POST['profId'];
	$ISBN = $_POST['ISBN'];
	$semester = $_POST['semester'];
	$bookTitle = $_POST['bookTitle'];
	$author = $_POST['author'];
	$edition = $_POST['edition'];
	$publisher = $_POST['publisher'];

    // Prepared statement (security) to retrieve row.
    $query = "INSERT INTO book (bookTitle, author, edition, publisher, ISBN) VALUES (?,?,?,?,?)";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("ssdsi", $bookTitle, $author, $edition, $publisher, $ISBN);
    $preparedStatement->execute();
	// Return status code 200 and JSON of this existing user row/object.
	$insertQuery = "INSERT INTO request(profId, ISBN, semester) VALUES (?,?,?)";
	$insertstmt = $conn->prepare($insertQuery);
	$insertstmt->bind_param("iis", $profId, $ISBN, $semester);
	$insertstmt->execute();
    // If the user row/table exists or not.
    if ($insertstmt->errno == 0)
    {	
		$newQuery = "SELECT request.requestId, request.semester, book.ISBN, book.bookTitle, book.author, book.edition, book.publisher FROM request LEFT JOIN book ON request.ISBN = book.ISBN WHERE request.profId = ?";
		$stmt = $conn->prepare($newQuery);
		$stmt->bind_param("i", $profId);
		$stmt->execute();

		$resultTable = $stmt->get_result();
        
		$row = $resultTable->fetch_assoc();
		$ISBN = $row['ISBN'];
		$semester = $row['semester'];
		$bookTitle = $row['bookTitle'];
		$author = $row['author'];
		$edition = $row['edition'];
		$publisher = $row['publisher'];
		$requestId = $row['requestId'];
        // Create JSON of existing row.
        $request = array(
			'requestId'=>$requestId,
			'ISBN'=>$ISBN,
			'semester'=>$semester,
			'bookTitle'=>$bookTitle,
			'author'=>$author,
			'edition'=>$edition,
			'publisher'=>$publisher,
        );
        // Return status code 200 and JSON of this existing user row/object.
        ok();
        header("Content-Type: application/json");
        httpResponse($request);
    }
    // Otherwise, user doesn't exist. Return status code 400 BAD REQUEST. 
    else 
    {
        badRequest();
		header("Content-Type: application/json");
        httpResponse($insertstmt->error);
    }   
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>