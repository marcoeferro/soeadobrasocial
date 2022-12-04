<?php
    require_once "../api/DB.php";

    class CreateAuto
    {
        public function __construct(){}

        public static function createAuto($id_afiliado,
        $id_prestador,$id_estado,$id_administrador,
        $nombre_estudio,$fecha_aprobacion,$fecha_caducidad)
        {

            $conn = DB::connect();
            
            $sql = "INSERT INTO autorizaciones(id_afiliado,id_prestador,
            id_estado,id_administrador, nombre,fecha_aprobacion,
            fecha_caducidad) VALUES ($id_afiliado,$id_prestador,
            $id_estado,$id_administrador,'$nombre_estudio',$fecha_aprobacion,
            $fecha_caducidad)";

            $result = $conn->query($sql);
            if(!$result)
            {
                die("Query Failed");
            }
            return "Saved";
        }
    }