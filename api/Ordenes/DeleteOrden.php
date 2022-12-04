<?php
    require_once "../api/DB.php";

    class DeleteOrden
    {
        public function __construct(){}

        public static function deleteOrden($id){
            $conn = DB::connect();
            $sql = "DELETE FROM ordenesdeconsulta 
            WHERE ordenesdeconsulta.id_orden_consulta ='$id'";
            $result = $conn->query($sql);
            if(!$result)
            {
                die("Query Failed");
            }
            return "Deleted";
        }
    }