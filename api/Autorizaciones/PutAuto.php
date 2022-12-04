<?php
    require_once "../api/DB.php";

    class UpdateAuto
    {
        public function __construct(){}

        public static function updateAuto($id_afiliado,
        $id_prestador,$id_estado,$id_administrador,
        $nombre_estudio,$fecha_aprobacion,$fecha_caducidad,$id)
        {

            $conn = DB::connect();
            
            $sql = "UPDATE autorizaciones a SET a.id_afiliado=$id_afiliado,
            a.id_prestador=$id_prestador,a.id_estado=$id_estado,
            a.id_administrador=$id_administrador, a.nombre ='$nombre_estudio', 
            a.fecha_aprobacion ='$fecha_aprobacion',a.fecha_caducidad = '$fecha_caducidad'
            WHERE a.id_autorizacion =$id";

            $result = $conn->query($sql);
            if(!$result)
            {
                die("Query Failed");
            }
            return "Updated";
        }
    }