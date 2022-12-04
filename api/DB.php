<?php
    class DB 
    {
        public static function connect()
        {
            $servername = "localhost";
            $username = "root";
            $password = "";

            try {
            $conn = new PDO("mysql:host=$servername;dbname=newschema", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
            } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            }
            return $conn;
        }   
    } 
    
?>
    
