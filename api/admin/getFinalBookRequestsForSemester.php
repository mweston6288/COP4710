<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Get the current semester's details
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
    else
    {
        // Something went wrong
        badRequest();
    }

    // Update the new semester.
    $newSemester;
    $newYear;
    // If current semester is fall, next is spring of next year
    if ($currentSemester === "Fall") 
    {
        $newSemester = "Spring";
        $newYear = $currentYear+1;
    }
    // If current semester is spring, next is summer
    else if ($currentSemester === "Spring")
    {
        $newSemester = "Summer";
        $newYear = $currentYear;
    }
    // If current semester is summer, next is fall
    else
    {
        $newSemester = "Fall";
        $newYear = $currentYear;
    }
    
    $query = "UPDATE currentSemester SET semester = ?, year = ? WHERE semester = ? AND year = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("sisi", $newSemester, $newYear, $currentSemester, $currentYear);
    $preparedStatement->execute();
    $resultTable = $preparedStatement->get_result();

    // Get the list of requests for the current semester.
    $semesterString = $currentSemester . " " . strval($currentYear);
    $query = "SELECT p.profId, p.name, COUNT(*) AS bookAmount FROM request AS r JOIN professor AS p ON r.profId = p.profId WHERE r.semester = ? GROUP BY p.profId, p.name";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("s", $semesterString);
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
            'semester' => $semesterString
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