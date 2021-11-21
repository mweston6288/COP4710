<?php
    // Class to quickly log into the database
    class Server
    {
        private $hostname;
        private $username;
        private $password;
        private $database;

        function __construct()
        {
            $this->hostname = '127.0.0.2:3306';
            $this->username = 'root';
            $this->password = 'test';
            $this->database = 'db';
        }

        // Creates and returns mysqli object
        function connect()
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
            if ($conn->connect_error)
                die("Error connecting to database!<br>Error: $conn->connect_error");
            
            return $conn;  
        }
    }
?>