<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();
         
    // Retrieve the deadline date from the HTTP Request body.
    $data = httpRequest();
    $profId = $data['profId'];
    $semester = $data['semester'];
    
    // Get all the books associated with this book request.
    $query = "SELECT b.ISBN, b.bookTitle, b.author, b.edition, b.publisher FROM request AS r JOIN book AS b ON r.ISBN = b.ISBN WHERE r.semester = ? AND r.profId = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("si", $semester, $profId);
    $preparedStatement->execute();
    $resultTable = $preparedStatement->get_result();

    // Iterate through all the books in this particular request and append to a nested associative array.
    $books = array();
    for ($i = 0; $i < $resultTable->num_rows; $i++)
    {
        $row = $resultTable->fetch_assoc();
        $ISBN = $row['ISBN'];
        $bookTitle = $row['bookTitle'];
        $author = $row['author'];
        $edition = $row['edition'];
        $publisher = $row['publisher'];

        $book = array(
            'ISBN' => $ISBN,
            'bookTitle' => $bookTitle,
            'author' => $author,
            'edition' => $edition,
            'publisher' => $publisher
        );

        array_push($books, $book);
    }

    // Store the results in an associative array to convert to JSON.
    $data = array(
        'books' => $books,
        'count' => count($books)
    );

    // Return status code 200 and JSON of the admins.
    ok();
    header("Content-Type: application/json");
    httpResponse($data);
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>

