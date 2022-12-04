<?php
    require_once "DB.php";
    
    class GetPrestadores
    {
        public $nombrePrestador;
        public $apellido;
        public $telefono;
        public $matricula;
        public $nombreEspecialidad;
        public $nombreCentro;

        public function __construct(){}

        public static function getAll(){
            $conn = DB::connect();
            $sql = "SELECT p.nombre as nombrePrestador, p.apellido, p.telefono, p.matricula, e.nombre as nombreEspecialidad, c.nombre as nombreCentro
            FROM prestadores p JOIN prestadores_especialidad pe ON p.id_prestador = pe.IdPrestador 
            JOIN especialidades e ON e.id_especialidad = pe.IdEspecialidad 
            JOIN centros c ON c.id_centro = p.id_centro";
            $stmt = $conn->query($sql);
            $result = $stmt->fetchAll();
            $prestadores = array();
            foreach($result as $row){
                $prestador = new GetPrestadores();
                $prestador->nombrePrestador = $row['nombrePrestador'];
                $prestador->apellido = $row['apellido'];
                $prestador->telefono = $row['telefono'];
                $prestador->matricula = $row['matricula'];
                $prestador->nombreEspecialidad = $row['nombreEspecialidad'];
                $prestador->nombreCentro = $row['nombreCentro'];
                array_push($prestadores,$prestador);
            }
            return json_encode($prestadores);
        }
    }

    ?>    
    
    