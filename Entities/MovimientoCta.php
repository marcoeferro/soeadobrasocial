<?php
    include_once(dirname(__FILE__)."/db.php");

    class MovimientoCta{

        public $id;
        public $fecha;
        public $nombre;
        public $debe;
        public $haber;
        public $total;
        public $saldo;
        public $detalles;
        

        public function __construct()
        {
            
        }

        public static function getAll($idFarmacia = null){
            $conn = db::connect();
            $sql = "exec spSaldosWeb_select @idFarmacia = :idFarmacia";
            $records = $conn->prepare($sql);
            $records->bindParam(':idFarmacia',$idFarmacia);
            $records->execute();
            $result = $records->fetchAll(PDO::FETCH_ASSOC);

            $movimientos = array();
            foreach($result as $row){
                if(isset($row['ID'])) {
                    $movimiento = new MovimientoCta();
                    $movimiento->id = $row['ID'];
                    $movimiento->fecha = date('d-m-Y',strtotime($row['Fecha']));
                    $movimiento->nombre = $row['Concepto'];
                    $movimiento->debe = (float)$row['Debe'] == 0? null: $row['Debe'];
                    $movimiento->haber = (float)$row['Haber'] == 0? null: $row['Haber'];
                    //$movimiento->total = (float)$row['Total'] == 0? null: $row['Total'];
                    $movimiento->saldo = (float)$row['Saldo'] == 0? null: $row['Saldo'];
                    $movimiento->detalles = array();
                    array_push($movimientos,$movimiento);
                }else{
                    $detalle = new Detalle();
                    $detalle->fecha = date('d-m-Y',strtotime($row['Fecha']));
                    $detalle->nombre = $row['Concepto'];
                    $detalle->debe = $row['Debe'] == 0? null: $row['Debe'];
                    $detalle->haber = $row['Haber'] == 0? null: $row['Haber'];
                    //$detalle->total = $row['Total'] == 0? null: $row['Total'];
                    $index = count($movimientos)-1;
                    $movimiento = $movimientos[$index];
                    array_push($movimiento->detalles,$detalle);
                }
            }
            return $movimientos;
        }

        public static function getPagosBy($idFarmacia = null, $idObraSocial = null, $idPeriodo = null){
            $conn = db::connect();
            $sql = "exec spPagosPeriodo_Select @idFarmacia = :idFarmacia, @idObraSocial = :idObraSocial, @idPeriodo = :idPeriodo";
            $records = $conn->prepare($sql);
            $records->bindParam(':idFarmacia',$idFarmacia);
            $records->bindParam(':idObraSocial',$idObraSocial);
            $records->bindParam(':idPeriodo',$idPeriodo);
            $records->execute();
            $result = $records->fetchAll(PDO::FETCH_ASSOC);

            $liquidaciones = array();
            foreach($result as $row){
                if(isset($row['ID'])) {
                    $liquidacion = new MovimientoCta();
                    $liquidacion->id = $row['ID'];
                    $liquidacion->fecha = date('d-m-Y',strtotime($row['Fecha']));
                    $liquidacion->nombre = $row['Concepto'];
                    $liquidacion->debe = (float)$row['Debe'] == 0? null: $row['Debe'];
                    $liquidacion->haber = (float)$row['Haber'] == 0? null: $row['Haber'];
                    $liquidacion->total = (float)$row['Total'] == 0? null: $row['Total'];
                    //$liquidacion->saldo = (float)$row['Saldo'] == 0? null: $row['Saldo'];
                    $liquidacion->detalles = array();
                    array_push($liquidaciones,$liquidacion);
                }else{
                    $detalle = new Detalle();
                    $detalle->fecha = date('d-m-Y',strtotime($row['Fecha']));
                    $detalle->nombre = $row['Concepto'];
                    $detalle->debe = $row['Debe'] == 0? null: $row['Debe'];
                    $detalle->haber = $row['Haber'] == 0? null: $row['Haber'];
                    $detalle->total = null;
                    $index = count($liquidaciones)-1;
                    $liquidacion = $liquidaciones[$index];
                    array_push($liquidacion->detalles,$detalle);
                }
            }

            return $liquidaciones;
        }
    }

    class Detalle{
        public $fecha;
        public $nombre;
        public $debito;
        public $credito;
        public $total;
    }
?>