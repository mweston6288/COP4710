<?php
    require_once './utility/dbLogin.php';
    require_once './utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();
            
    $query = "SELECT * FROM professor";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->execute();
    $resultTable = $preparedStatement->get_result();

    // Iterate through all the professors and append to a nested associative array.
    $professors = array();
    for ($i = 0; $i < $resultTable->num_rows; $i++)
    {
        $row = $resultTable->fetch_assoc();
        $professorID = $row['profId'];
        $email = $row['email'];
        $name = $row['name'];

        $professor = array(
            'professorID' => $professorID,
            'email' => $email,
            'name' => $name
        );

        array_push($professors, $professor);
    }

    // Store the results in an associative array to convert to JSON.
    $data = array(
        'professors' => $professors,
        'count' => count($professors)
    );

    // Return status code 200 and JSON of the professors.
    ok();
    header("Content-Type: application/json");
    httpResponse($data);
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>