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
    
    // Get all the ISBNs associated with the request.
    $query = "SELECT * FROM request WHERE profId = ? AND semester = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("is", $profId, $semester);
    $preparedStatement->execute();
    $resultTable = $preparedStatement->get_result();

    $ISBNs = array();
    for ($i = 0; $i < $resultTable->num_rows; $i++)
    {
        $row = $resultTable->fetch_assoc();
        $ISBN = $row['ISBN'];

        array_push($ISBNs, $ISBN);
    }

    // Delete all the books and requests associated with the ISBNs.
    for ($i = 0; $i < count($ISBNs); $i++)
    {
        $ISBN = $ISBNs[$i];

        $query = "DELETE FROM request WHERE ISBN = ?";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param("i", $ISBN);
        $preparedStatement->execute();

        $query = "DELETE FROM book WHERE ISBN = ?";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param("i", $ISBN);
        $preparedStatement->execute();
    }

    // 200 OK for successful attempt
    ok();

    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>