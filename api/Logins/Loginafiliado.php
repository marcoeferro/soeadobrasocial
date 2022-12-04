<?php
    require_once "../DB.php";
    
    class LoginAdmin
    {
        public function __construct(){}

        public static function login($user,$pass)
        {
            $conn = DB::connect();
            $sql = "SELECT a.Usuario,a.Password FROM administradores a 
            WHERE a.Usuario = '$user' AND a.Password = '$pass'";
            
            $stmt = $conn->query($sql);
            $result = $stmt->fetchAll();
            
            if (!empty($result)) 
            {
                header('Location: ../../index.php');
                die();
            }
        }
    }