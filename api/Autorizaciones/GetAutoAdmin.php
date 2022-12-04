<?php
    require_once "../DB.php";
    
    class GetAutoAdmin
    {
        public $idAutorizacion;
        public $fecha_aprobacion_autorizacion;
        public $nombre_afiliado;
        public $apellido_afiliado;
        public $nro_afiliado;
        public $prestador_nombre;
        public $prestador_apellido;
        public $estado_autorizacion;


        public function __construct(){}

        public static function getAll(){
            $conn = DB::connect();
            $sql = "SELECT a.id_autorizacion as idAutorizacion, a.fecha_aprobacion as fecha_aprobacion_autorizacion,
            af.nombre as nombre_afiliado,af.apellido as apellido_afiliado,af.nro_afiliado as nro_afiliado,
            p.nombre as prestador_nombre,p.apellido as prestador_apellido,e.nombre as estado_autorizacion
            FROM autorizaciones a JOIN afiliados af ON a.id_afiliado = af.id_afiliado 
            JOIN estados e ON a.id_estado = e.id_estado 
            JOIN prestadores p ON a.id_prestador = p.id_prestador;";
            $stmt = $conn->query($sql);
            $result = $stmt->fetchAll();
            $autorizaciones = array();
            foreach($result as $row){
                $autorizacion = new GetAutoAdmin();
                $autorizacion->idAutorizacion = $row['idAutorizacion'];
                $autorizacion->fecha_aprobacion_autorizacion = $row['fecha_aprobacion_autorizacion'];
                $autorizacion->nombre_afiliado = $row['nombre_afiliado'];
                $autorizacion->apellido_afiliado = $row['apellido_afiliado'];
                $autorizacion->nro_afiliado = $row['nro_afiliado'];
                $autorizacion->prestador_nombre = $row['prestador_nombre'];
                $autorizacion->prestador_apellido = $row['prestador_apellido'];
                $autorizacion->estado_autorizacion = $row['estado_autorizacion'];
                array_push($autorizaciones,$autorizacion);
            }
            return json_encode($autorizaciones);
        }
    }
    
    