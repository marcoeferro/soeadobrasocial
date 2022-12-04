<?php 
    include_once(dirname(__FILE__)."/db.php");

    class ObraSocial{
        public $ID;
        public $Nombre;

        public function __construct($ID = null, $Nombre = null){
            $this->ID = $ID;
            $this->Nombre = $Nombre;
        }

        /* devuelve todas las obras sociales */
        public static function get_all()
        {
            $conn = db::connect();
            $sql = "SELECT
                    os.id AS ID,
                    os.Nombre AS Nombre
                FROM ObrasSociales os";
            
            $stmt = $conn->query($sql);
            $result = $stmt->fetchAll();
            $obrasSociales = array();
            foreach($result as $row){
                $obraSocial = new ObraSocial();
                $obraSocial->ID = $row['ID'];
                $obraSocial->Nombre = $row['Nombre'];

                array_push($obrasSociales,$obraSocial);
            }

            return $obrasSociales;
        }
        
        /* retorna una unica obra social por su id */
        public static function get_by($id){

            $conn = db::connect();
            $sql = "SELECT
                    os.id AS ID,
                    os.Nombre AS Nombre
                FROM ObrasSociales os
                WHERE os.id = :id
            ";

            $records = $conn->prepare($sql);
            $records->bindParam(':id',$id);
            $records->execute();
            $result = $records->fetch(PDO::FETCH_ASSOC);

            $obraSocial = new ObraSocial();
            $obraSocial->ID = $result['ID'];
            $obraSocial->Nombre = $result['Nombre'];
            //$obraSocial->IdPlan = $result['IdPlan'];

            return $obraSocial;
        }
    }
?>