<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Retrieve the data from the HTTP Request body.
    $data = httpRequest();
    $profId = $data['profId'];
    $semester = $data['semester'];
    $books = $data['books'];
    
    // Respond with error if request is submitting a new book with an existing ISBN
    for ($i = 0; $i < count($books); $i++)
    {
        $ISBN = $books[$i]["ISBN"];

        $query = "SELECT * FROM book WHERE ISBN = ?";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param("i", $ISBN);
        $preparedStatement->execute();
        $resultTable = $preparedStatement->get_result();

        if ($resultTable->num_rows > 0)
        {
            badRequest();
            exit;
        }
    }

    // Insert the books and book requests into DB.
    for ($i = 0; $i < count($books); $i++)
    {
        $bookTitle = $books[$i]["bookTitle"];
        $author = $books[$i]["author"];
        $edition = $books[$i]["edition"];
        $publisher = $books[$i]["publisher"];
        $ISBN = $books[$i]["ISBN"];

        // Insert into the book and request tables.
        $query = "INSERT INTO book(ISBN, bookTitle, author, edition, publisher) VALUES(?, ?, ?, ?, ?)";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param("issds", $ISBN, $bookTitle, $author, $edition, $publisher);
        $preparedStatement->execute();

        $query = "INSERT INTO request(profId, ISBN, semester) VALUES(?, ?, ?)";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param("iis", $profId, $ISBN, $semester);
        $preparedStatement->execute();
    }

    // Returns HTTP header 201 CREATED
    created();
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>