<?php
    require_once "../DB.php";
    
    class GetAfil
    {
        public $id_afiliado;
        public $nombre_afiliado;
        public $apellido_afiliado;
        public $nro_afiliado;
        public $nro_asociado;
        public $dni;

        public function __construct(){}

        public static function getAll(){
            $conn = DB::connect();
            $sql = "SELECT id_afiliado,
            nombre as nombre_afiliado, apellido as apellido_afiliado,
            nro_afiliado,nro_asociado, dni 
            FROM afiliados";
            $stmt = $conn->query($sql);
            $result = $stmt->fetchAll();
            $afiliados = array();
            foreach($result as $row){
                $afiliado = new GetAfil();
                $afiliado->id_afiliado = $row['id_afiliado'];
                $afiliado->nombre_afiliado = $row['nombre_afiliado'];
                $afiliado->apellido_afiliado = $row['apellido_afiliado'];
                $afiliado->nro_afiliado = $row['nro_afiliado'];
                $afiliado->nro_asociado = $row['nro_asociado'];
                $afiliado->dni = $row['dni'];
                array_push($afiliados,$afiliado);
            }
            return json_encode($afiliados);
        }
    }
    
    