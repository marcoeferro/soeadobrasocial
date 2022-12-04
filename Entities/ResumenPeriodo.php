<?php 
    include_once(dirname(__FILE__)."/db.php");
    include_once(dirname(__FILE__)."/Periodo.php");
    include_once(dirname(__FILE__)."/ObraSocial.php");

    class ResumenPeriodo{
        public $idFarmacia;
        public $obraSocial;
        public $periodo;
        public $presentacion_final;
        public $presentacion_web;
        public $presentacion_local;
        public $status;
        public $pagos;
        public $statusMensaje;
        public $mensajeWeb;


        public function __construct(){
            
        }

        public static function getBy($idFarmacia = null, $idObraSocial = null, $idPeriodo = null){
            $conn = db::connect();
            $sql = "exec spResumenPeriodo_Select @idFarmacia = :idFarmacia, @idObraSocial = :idObraSocial, @idPeriodo = :idPeriodo";
            $records = $conn->prepare($sql);
            $records->bindParam(":idFarmacia", $idFarmacia);
            $records->bindParam(":idObraSocial", $idObraSocial);
            $records->bindParam(":idPeriodo", $idPeriodo);
            $records->execute();
            $result = $records->fetchAll(PDO::FETCH_ASSOC);

            $ResumenesList = array();
            foreach($result as $row){
                $resumenPeriodo = new ResumenPeriodo();
                $resumenPeriodo->idFarmacia = $row['IdFarmacia'];
                $resumenPeriodo->obraSocial = new ObraSocial($row['IdObraSocial'], $row['ObraSocial']);
                $resumenPeriodo->periodo = new Periodo(
                    $row['IdPeriodo'], 
                    null,
                    $row['IdObraSocial'],
                    $row['ObraSocial'],
                    $row['Periodo'],
                    null,
                    $row['FechaLimite']
                );
                $resumenPeriodo->presentacion_final = new PresentacionStruct(
                    ($row['Recetas_L'] == null ? $row['Recetas_W']: $row['Recetas_L']),
                    ($row['Recaudado_L'] == null ? $row['Recaudado_W']: $row['Recaudado_L']),
                    ($row['AcargoOS_L'] == null ? $row['AcargoOS_W']: $row['AcargoOS_L'])
                );
                $resumenPeriodo->presentacion_web = new PresentacionStruct(
                    $row['Recetas_W'],
                    $row['Recaudado_W'],
                    $row['AcargoOS_W']
                );
                $resumenPeriodo->presentacion_local = new PresentacionStruct(
                    $row['Recetas_L'],
                    $row['Recaudado_L'],
                    $row['AcargoOS_L']
                );

                if ($row['Recetas_L'] == $row['Recetas_W'] && $row['Recaudado_L'] == $row['Recaudado_W'] && $row['AcargoOS_L'] == $row['AcargoOS_W']){
                    $resumenPeriodo->status = 1;
                    $resumenPeriodo->statusMensaje = "Verificado y acepatado.";
                }elseif(is_null($row['Recetas_L']) && is_null($row['Recaudado_L']) && is_null($row['AcargoOS_L'])){
                    $resumenPeriodo->status = -1;
                    $resumenPeriodo->statusMensaje = "Pendiente, sin confirmación del centro.";
                }elseif(is_null($row['Recetas_W']) && is_null($row['Recaudado_W']) && is_null($row['AcargoOS_W'])){
                    $resumenPeriodo->status = 0;
                    $resumenPeriodo->statusMensaje = "Datos cargados desde el centro.";
                }else{
                    $resumenPeriodo->status = 2;
                    $resumenPeriodo->statusMensaje = "Aceptado, con correcciones.";
                }

                $resumenPeriodo->pagos = $row['Pagos'];

                $resumenPeriodo->mensajeWeb = $row['MensajeWeb'];

                array_push($ResumenesList, $resumenPeriodo);
            }
            return $ResumenesList;
        }
    }

    class PresentacionStruct{
        public $recetas;
        public $recaudado;
        public $aCargoOS;

        public function __construct($recetas, $recaudado, $aCargoOS){
            $this->recetas = $recetas;
            $this->recaudado = $recaudado;
            $this->aCargoOS = $aCargoOS;
        }
    }

?>