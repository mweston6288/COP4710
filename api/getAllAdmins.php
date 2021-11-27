<?php
    require_once './utility/dbLogin.php';
    require_once './utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();
            
    $query = "SELECT * FROM admin";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->execute();
    $resultTable = $preparedStatement->get_result();

    // Iterate through all the admins and append to a nested associative array.
    $admins = array();
    for ($i = 0; $i < $resultTable->num_rows; $i++)
    {
        $row = $resultTable->fetch_assoc();
        $adminID = $row['adminId'];
        $username = $row['username'];
        $password = $row['password'];

        $admin = array(
            'adminID' => $adminID,
            'username' => $username,
            'password' => $password
        );

        array_push($admins, $admin);
    }

    // Store the results in an associative array to convert to JSON.
    $data = array(
        'admins' => $admins,
        'count' => count($admins)
    );

    // Return status code 200 and JSON of the contacts for this user.
    ok();
    header("Content-Type: application/json");
    httpResponse($data);
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>