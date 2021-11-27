<?php
    require_once '../utility/dbLogin.php';
    require_once '../utility/httpPackage.php';

    // Connect to database.
    $server = new Server();
    $conn = $server->connect();

    // Retrieve the data from the HTTP Request body.
    $data = httpRequest();
    $professorID = $data['professorID'];
            
    // Delete the professor with the selected id.
    $query = "DELETE FROM professor WHERE profId = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param("i", $professorID);
    $preparedStatement->execute();

    // Return with 204 NO CONTENT HTTP header for successful deletion.
    noContent();
    
    // Close the database at end of script
    $preparedStatement->close();
    $conn->close();
    exit;
?>