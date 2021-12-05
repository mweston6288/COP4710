<?php
    require "dbLoginData.php";
    // Class to quickly log into the database
    class Server
    {
        private $hostname;
        private $username;
        private $password;
        private $database;

        function __construct()
        {
            global $hostname;
            global $username;
            global $password;
            global $database;
            
            $this->hostname = $hostname;
            $this->username = $username;
            $this->password = $password;
            $this->database = $database;
        }

        // Creates and returns mysqli object
        function connect()
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
            if ($conn->connect_error)
                die("Error connecting to database! Check the dbLoginData file<br>Error: $conn->connect_error");
            
            return $conn;  
        }
    }
?>