<?php 
    include_once(dirname(__FILE__)."/db.php");

        /*Periodo
        static methods:
            getAll()
            getCurrent($idObraSocial)
            getExpired($idObraSocial)
    */

    class Periodo{
        
        public $id;
        public $mandataria;
        public $idObraSocial;
        public $obraSocial;
        public $periodo;
        public $fechaComienzo;
        public $fechaLimite;

        public function __construct($id = null, $mandataria = null, $idObraSocial = null, $obraSocial = null, $periodo = null, $fechaComienzo = null, $fechaLimite = null){
            $this->id = $id;
            $this->mandataria = $mandataria;
            $this->idObraSocial = $idObraSocial;
            $this->obraSocial = $obraSocial;
            $this->periodo = $periodo;
            $this->fechaComienzo = $fechaComienzo;
            $this->fechaLimite = $fechaLimite;
        }

        /* trae unicamente el periodo vigente */
        public static function getCurrent($idObraSocial){
            $conn = db::connect();
            $sql = "exec spPeriodosWeb_SelectCurrent @IdObraSocial = :idObraSocial";
            $records = $conn->prepare($sql);
            $records->bindParam(':idObraSocial',$idObraSocial);
            $records->execute();
            $records->nextRowset();
            $result = $records->fetch(PDO::FETCH_ASSOC);


            $periodo = new Periodo();
            $periodo->id = $result['ID'];
            $periodo->mandataria = $result['Mandataria'];
            $periodo->idObraSocial = $result['IdObraSocial'];
            $periodo->obraSocial = $result['ObraSocial'];
            $periodo->periodo = $result['Periodo'];
            $periodo->fechaComienzo = $result['Comienzo'];
            $periodo->fechaLimite = $result['FechaLimite'];

            return $periodo;
        }

        /* trae los periodos vencidos */
        public static function getExpired($idObraSocial){

            $conn = db::connect();
            $sql = "exec spPeriodosWeb_SelectExpired :idObraSocial";
            $records = $conn->prepare($sql);
            $records->bindParam(':idObraSocial',$idObraSocial);
            $records->execute();
            $records->nextRowset();
            $result = $records->fetchAll(PDO::FETCH_ASSOC);

            $periodos = array();
            foreach($result as $row){
                $periodo = new Periodo();
                $periodo->id = $row['ID'];
                $periodo->mandataria = $row['Mandataria'];
                $periodo->idObraSocial = $row['IdObraSocial'];
                $periodo->obraSocial = $row['ObraSocial'];
                $periodo->periodo = $row['Periodo'];
                $periodo->fechaComienzo = $row['Comienzo'];
                $periodo->fechaLimite = $row['FechaLimite'];
                array_push($periodos,$periodo);
            }

            return $periodos;
        }

        public static function getUpcoming($limit = null){
            $conn = db::connect();
            $sql = "exec spPeriodosWeb_SelectUpcoming :limit";
            $records = $conn->prepare($sql);
            $records->bindParam(':limit',$limit);
            $records->execute();
            /* $records->nextRowset(); */
            $result = $records->fetchAll(PDO::FETCH_ASSOC);

            $periodos = array();
            foreach($result as $row){
                $periodo = new Periodo();
                $periodo->id = $row['ID'];
                $periodo->mandataria = $row['Mandataria'];
                $periodo->idObraSocial = $row['IdObraSocial'];
                $periodo->obraSocial = $row['ObraSocial'];
                $periodo->periodo = $row['Periodo'];
                $periodo->fechaComienzo = $row['Comienzo'];
                $periodo->fechaLimite = $row['FechaLimite'];
                array_push($periodos,$periodo);
            }

            return $periodos;
        }

        public static function getForMonth($mes, $anio){
            $conn = db::connect();
            $sql = "exec spPeriodosWeb_SelectForMonth :mes, :anio";
            $records = $conn->prepare($sql);
            $records->bindParam(':mes',$mes);
            $records->bindParam(':anio',$anio);
            $records->execute();
            /* $records->nextRowset(); */
            $result = $records->fetchAll(PDO::FETCH_ASSOC);

            $periodos = array();
            foreach($result as $row){
                $periodo = new Periodo();
                $periodo->id = $row['ID'];
                $periodo->mandataria = $row['Mandataria'];
                $periodo->idObraSocial = $row['IdObraSocial'];
                $periodo->obraSocial = $row['ObraSocial'];
                $periodo->periodo = $row['Periodo'];
                $periodo->fechaComienzo = $row['Comienzo'];
                $periodo->fechaLimite = $row['FechaLimite'];
                array_push($periodos,$periodo);
            }

            return $periodos;
        }
    }