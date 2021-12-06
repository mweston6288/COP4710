<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Retrieve the data from the HTTP Request body.
    $data = httpRequest();
    $adminId = $data['adminId'];
    $newPassword = $data['newPassword'];
            
    // Change admin password with given id.
    $query = "UPDATE admin SET password = ? WHERE adminId = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("si", $newPassword, $adminId);
    $preparedStatement->execute();

    // Return with 204 NO CONTENT HTTP header for successful edit.
    noContent();
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>