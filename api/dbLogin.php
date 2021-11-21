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
            $this->hostname = 'cop4710_db_1';
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