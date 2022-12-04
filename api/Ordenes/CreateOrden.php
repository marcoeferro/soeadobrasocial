<?php
    
    require_once "../api/DB.php";

    class CreateOrden
    {
        public function __construct(){}

        public static function createOrden(
        $id_afiliado,
        $idPrestador_Servicio,
        $fecha_emision,
        $monto,
        $Cancelada,
        $FechaCancelada) 
        {
            $conn = DB::connect();
            
            $sql = "INSERT INTO ordenesdeconsulta 
            ( 
            id_afiliado, 
            idPrestador_Servicio,
            fecha_emision,
            monto,
            Cancelada,
            FechaCancelada) VALUES (
            $id_afiliado,
            $idPrestador_Servicio,
            '$fecha_emision',
            $monto,
            $Cancelada,
            '$FechaCancelada')";

            $result = $conn->query($sql);
            if(!$result)
            {
                die("Query Failed");
            }
            return "Created";
        }
    }