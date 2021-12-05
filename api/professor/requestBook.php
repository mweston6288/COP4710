<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Retrieve the data from the HTTP Request body.
    $_POST = httpRequest();
    $profId = $_POST['profId'];
	$ISBN = $_POST['ISBN'];
	$semester = $_POST['semester'];
	$bookTitle = $_POST['bookTitle'];
	$author = $_POST['author'];
	$edition = $_POST['edition'];
	$publisher = $_POST['publisher'];

    // First insert the requested book into the book database. No concern if it fails
    $query = "INSERT INTO book (bookTitle, author, edition, publisher, ISBN) VALUES (?,?,?,?,?)";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("ssdsi", $bookTitle, $author, $edition, $publisher, $ISBN);
    $preparedStatement->execute();
	// Next, save a request of the book
	$insertQuery = "INSERT INTO request(profId, ISBN, semester) VALUES (?,?,?)";
	$insertstmt = $conn->prepare($insertQuery);
	$insertstmt->bind_param("iis", $profId, $ISBN, $semester);
	$insertstmt->execute();
    // If no errors occurred.
    if ($insertstmt->errno == 0)
    {	
        // get all currently existing requests and send them back
		$newQuery = "SELECT request.requestId, request.semester, book.ISBN, book.bookTitle, book.author, book.edition, book.publisher FROM request LEFT JOIN book ON request.ISBN = book.ISBN WHERE request.profId = ?";
		$stmt = $conn->prepare($newQuery);
		$stmt->bind_param("i", $profId);
		$stmt->execute();

		$resultTable = $stmt->get_result();
        
		$request = array();
        // Create JSON of existing rows.
        while($row = $resultTable->fetch_assoc()){
			$request[]=$row;
		}

        // Return status code 200 and JSON of all entries.
        ok();
        header("Content-Type: application/json");
        httpResponse($request);
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