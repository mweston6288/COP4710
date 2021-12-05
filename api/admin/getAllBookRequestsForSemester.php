<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();
            
    // Retrieve the data from the HTTP Request body.
    $data = httpRequest();
    $semester = $data['semester'];

    $query = "SELECT p.profId, p.name, COUNT(*) AS bookAmount FROM request AS r JOIN professor AS p ON r.profId = p.profId WHERE r.semester = ? GROUP BY p.profId, p.name";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("s", $semester);
    $preparedStatement->execute();
    $resultTable = $preparedStatement->get_result();

    // Iterate through all the requests and append to a nested associative array.
    $requests = array();
    for ($i = 0; $i < $resultTable->num_rows; $i++)
    {
        $row = $resultTable->fetch_assoc();
        $profId = $row['profId'];
        $name = $row['name'];
        $bookAmount = $row['bookAmount'];

        $request = array(
            'profId' => $profId,
            'name' => $name,
            'bookAmount' => $bookAmount,
            'semester' => $semester
        );

        array_push($requests, $request);
    }

    // Store the results in an associative array to convert to JSON.
    $data = array(
        'requests' => $requests,
        'count' => count($requests)
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