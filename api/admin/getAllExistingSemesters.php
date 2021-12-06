<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Get all the semesters currently active in the database.
    $query = "SELECT DISTINCT semester FROM request";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->execute();
    $resultTable = $preparedStatement->get_result();

    // Iterate through all the semesters and append to a nested associative array.
    $semesters = array();
    for ($i = 0; $i < $resultTable->num_rows; $i++)
    {
        $row = $resultTable->fetch_assoc();
        $semester = $row['semester'];

        array_push($semesters, $semester);
    }

    // Store the results in an associative array to convert to JSON.
    $data = array(
        'semesters' => $semesters,
        'count' => count($semesters)
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