<?php
    /* HACER CAMBIOS EN LA BASE DE DATOS PARA PODER ELIMINAR 
    PROBLEMAS CON LOS FOREIGN KEYS */
       require_once "../api/DB.php";

       class DeletePrestador
       {
           public function __construct(){}
   
           public static function deletePrestador($id)
           {
               $conn = DB::connect();
               $sql = "DELETE FROM prestadores
               WHERE prestadores.id_prestador ='$id'";
               
               $result = $conn->query($sql);
               if(!$result)
               {
                   die("Query Failed");
               }
               return "Deleted";
           }
       }