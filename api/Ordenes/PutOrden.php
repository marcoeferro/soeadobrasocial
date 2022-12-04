<?php
    require_once "../api/DB.php";

    class UpdateOrden
    {
        public function __construct(){}
        
        public static function updateorden(
        $id,
        $id_afiliado,
        $idPrestador_Servicio,
        $fecha_emision,
        $monto,
        $Cancelada,
        $FechaCancelada)
        {

            $conn = DB::connect();
            
            $sql = "UPDATE ordenesdeconsulta o 
            SET o.id_afiliado = $id_afiliado, 
            o.idPrestador_Servicio = $idPrestador_Servicio, 
            o.fecha_emision = $fecha_emision,
            o.monto = $monto, 
            o.Cancelada = $Cancelada,
            o.FechaCancelada = $FechaCancelada
            WHERE o.id_orden_consulta = $id";

            $result = $conn->query($sql);

            if(!$result)
            {
                die("Query Failed");
            }
            return "Updated";
        }
    }