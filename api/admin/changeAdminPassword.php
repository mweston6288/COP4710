<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Retrieve the data from the HTTP Request body.
    $data = httpRequest();
    $adminID = $data['adminID'];
    $newPassword = $data['newPassword'];
            
    // Change admin password with given id.
    $query = "UPDATE admin SET password = ? WHERE adminId = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("si", $newPassword, $adminID);
    $preparedStatement->execute();

    // Return with 204 NO CONTENT HTTP header for successful deletion.
    noContent();
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>