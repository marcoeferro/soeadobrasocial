<?php
    require_once "../api/DB.php";

    class UpdatePrestador
    {
        public function __construct(){}
        
        public static function updateprestador(
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
            
            $sql = "UPDATE prestadores p SET 
            p.nombre_prestador = '$nombre_prestador',
            p.apellido_prestador = '$apellido_prestador',
            p.telefono_prestador = '$telefono_prestador',
            p.localidad_prestador = '$localidad_prestador',
            p.codigo_postal_prestador = '$codigo_postal_prestador',
            p.TipoIVA = '$TipoIVA',
            p.matricula = '$matricula',
            p.cuit_prestador = '$cuit_prestador',
            p.titulo_prestador = '$titulo_prestador',
            p.id_centro = '$id_centro' WHERE p.id_prestador = $id_prestador";
            $result = $conn->query($sql);

            if(!$result)
            {
                die("Query Failed");
            }
            return "Updated";
        }
    }