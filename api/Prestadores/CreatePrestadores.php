<?php
    require_once "../api/DB.php";

    class CreatePrestador
    {
        public function __construct(){}

        public static function createPrestador(
        $id_prestador,
        $nombre_prestador,
        $apellido_prestador,
        $telefono_prestador,
        $localidad_prestador,
        $codigo_postal_prestador,
        $TipoIVA,
        $matricula,
        $cuit_prestador,
        $titulo_prestador,
        $id_centro)
        {
            $conn = DB::connect();
            
            $sql = "INSERT INTO prestadores(
            id_prestador,
            nombre_prestador,
            apellido_prestador,
            telefono_prestador,
            localidad_prestador,
            codigo_postal_prestador,
            TipoIVA,
            matricula,
            cuit_prestador,
            titulo_prestador,
            id_centro) VALUES (
            '$id_prestador',
            '$nombre_prestador',
            '$apellido_prestador',
            '$telefono_prestador',
            '$localidad_prestador',
            '$codigo_postal_prestador',
            '$TipoIVA',
            '$matricula',
            '$cuit_prestador',
            '$titulo_prestador',
            '$id_centro')";

            $result = $conn->query($sql);
            if(!$result)
            {
                die("Query Failed");
            }
            return "Created";
        }
    }