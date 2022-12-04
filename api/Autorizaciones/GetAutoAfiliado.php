<?php
    require_once "../api/DB.php";

    class GetAutoAfil
    {
        public $nombre_autorizacion;
        public $fecha_aprobacion_autorizacion;
        public $nombre_prestador;
        public $apellido_prestador;
        public $nombre_estado;

        public function __construct(){}

        public static function getAll(){
            $conn = DB::connect();
            $sql = "SELECT a.nombre as nombre_autorizacion,a.fecha_aprobacion as fecha_aprobacion_autorizacion, 
            p.nombre as nombre_prestador, p.apellido as apellido_prestador, e.nombre as nombre_estado
            FROM autorizaciones a JOIN prestadores p ON a.id_prestador = p.id_prestador 
            
            JOIN estados e ON a.id_estado = e.id_estado";
            $stmt = $conn->query($sql);
            $result = $stmt->fetchAll();
            $autorizaciones = array();
            foreach($result as $row){
                $autorizacion = new GetAutoAfil();
                $autorizacion->nombre_autorizacion = $row['nombre_autorizacion'];
                $autorizacion->fecha_aprobacion_autorizacion = $row['fecha_aprobacion_autorizacion'];
                $autorizacion->nombre_prestador = $row['nombre_prestador'];
                $autorizacion->apellido_prestador = $row['apellido_prestador'];
                $autorizacion->nombre_estado = $row['nombre_estado'];
                array_push($autorizaciones,$autorizacion);
            }
            return json_encode($autorizaciones);
        }
    }