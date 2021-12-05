<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Retrieve the data from the HTTP Request body.
    $data = httpRequest();
    $profId = $data['profId'];
    $newPassword = $data['newPassword'];
            
    // Change admin password with given id.
    $query = "UPDATE professor SET password = ? WHERE profId = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("si", $newPassword, $profId);
    $preparedStatement->execute();

    // Return with 204 NO CONTENT HTTP header for successful edit.
    noContent();
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>