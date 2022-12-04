<?php
    require_once "../api/DB.php";

    class DeleteAfil
    {
        public function __construct(){}

        public static function deleteAfil($id){
            $conn = DB::connect();
            $sql = "DELETE FROM afiliados WHERE afiliados.id_afiliado ='$id'";
            $result = $conn->query($sql);
            if(!$result)
            {
                die("Query Failed");
            }
            return "Deleted";
        }
    }