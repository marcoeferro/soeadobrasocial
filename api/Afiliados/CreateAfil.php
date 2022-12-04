<?php
    /* MODIFICAR BASE DE DATOS 
    PARA QUE EL ID SEA AUTOINCREMENTAL */
    require_once "../api/DB.php";

    class CreateAfil
    {
        public function __construct(){}

        public static function createAfil(
        $id_afiliado,
        $nombre_afiliado,
        $apellido_afiliado,
        $nro_afiliado,
        $nro_asociado,
        $dni)
        {
            $conn = DB::connect();
            
            $sql = "INSERT INTO afiliados(
            id_afiliado,
            nombre,
            apellido,
            nro_afiliado,
            nro_asociado,
            dni) VALUES (
            '$id_afiliado',
            '$nombre_afiliado',
            '$apellido_afiliado',
            '$nro_afiliado',
            '$nro_asociado',
            '$dni')";

            $result = $conn->query($sql);
            if(!$result)
            {
                die("Query Failed");
            }
            return "Created";
        }
    }