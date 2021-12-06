<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();
            
    $query = "SELECT * FROM currentSemester";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->execute();
    $resultTable = $preparedStatement->get_result();

    $currentSemester;
    $currentYear;
    if ($resultTable->num_rows > 0)
    {
        $row = $resultTable->fetch_assoc();
        $currentSemester = $row['semester'];
        $currentYear = $row['year'];
    }

    $semester = $currentSemester . " " . strval($currentYear);
    // Store the results in an associative array to convert to JSON.
    $data = array(
        'currentSemester' => $semester
    );

    // Return status code 200.
    ok();
    header("Content-Type: application/json");
    httpResponse($data);
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>