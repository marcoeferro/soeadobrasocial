<?php
    require_once "../api/DB.php";
    
    class GetOrden
    {
        public $id_afiliado;
        public $idPrestador_Servicio;
        public $fecha_emision;
        public $monto;
        public $Cancelada;
        public $FechaCancelada;

        public function __construct(){}

        public static function getAll(){
            $conn = DB::connect();
            $sql = "SELECT id_afiliado,
            idPrestador_Servicio,
            fecha_emision,
            monto,
            Cancelada,
            FechaCancelada 
            FROM ordenesdeconsulta";
            $stmt = $conn->query($sql);
            $result = $stmt->fetchAll();
            $ordenes = array();
            foreach($result as $row){
                $orden = new GetOrden();
                $orden->id_afiliado = $row['id_afiliado'];
                $orden->idPrestador_Servicio = $row['idPrestador_Servicio'];
                $orden->fecha_emision = $row['fecha_emision'];
                $orden->monto = $row['monto'];
                $orden->Cancelada = $row['Cancelada'];
                $orden->FechaCancelada = $row['FechaCancelada'];
                array_push($ordenes,$orden);
            }
            return json_encode($ordenes);
        }
    }
    
    