<?php
    require_once "../api/DB.php";

    class UpdateAfil
    {
        public function __construct(){}
        
        public static function updateAfil(
        $nombre_afiliado,
        $apellido_afiliado,
        $nro_afiliado,
        $nro_asociado,
        $dni,
        $id)
        {

            $conn = DB::connect();
            
            $sql = "UPDATE afiliados a SET a.nombre = '$nombre_afiliado',
            a.apellido = '$apellido_afiliado',
            a.nro_afiliado =$nro_afiliado, 
            a.nro_asociado =$nro_asociado,
            a.dni = $dni
            WHERE a.id_afiliado = $id";

            $result = $conn->query($sql);

            if(!$result)
            {
                die("Query Failed");
            }
            return "Updated";
        }
    }