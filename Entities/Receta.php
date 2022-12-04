<?php 
    include_once(dirname(__FILE__)."/db.php");

    /*Receta
        methods:
            save()
            delete()
        static methods:
            getAll()
            getBy($idFarmacia, $idPeriodo, $idObraSocial)
            getGrouped($idFarmacia, $idPeriodo, $idObraSocial)
            staticDelete($id)
    */

    class Receta{
        public $id;
        public $fecha;
        public $idPeriodo;
        public $idFarmacia;
        public $idObraSocial;
        public $recetas;
        public $recaudado;
        public $aCargoOS;
        public $bonificacion;
        public $observaciones;
        public $userAdd;
        public $userDel;

        public function __construct(){

        }

        /*guardar receta (es necesario que el objeto este instanceado) */
        public function save(){
            if(
                $this->idPeriodo == null || 
                $this->idFarmacia == null || 
                $this->idObraSocial == null ||
                $this->recetas == null ||
                $this->recaudado == null || 
                $this->aCargoOS == null
            ){
                $error_msg = "Error al guardar receta: valores nulos \n 
                (idPeriodo, idFarmacia, recetas, recaudado, aCargoOS)";
                throw new Exception($error_msg);
            }

            $conn = db::connect();
            $sql = "
                insert into recetas_web
                (
                    IdFarmacia,
                    IdPeriodo,
                    IdObraSocial,
                    Recetas,
                    Recaudado,
                    AcargoOS,
                    Bonificacion,
                    Observaciones,
                    Eliminado,
                    DateAdd,
                    UserAdd
                ) values (
                    :IdFarmacia,
                    :IdPeriodo,
                    :IdObraSocial,
                    :Recetas,
                    :Recaudado,
                    :AcargoOS,
                    :Bonificacion,
                    :Observaciones,
                    0,
                    GETDATE(),
                    :user
                )
            ";

            $records = $conn->prepare($sql);
            try{
                $conn->beginTransaction();

                $records->bindParam(':IdFarmacia',$this->idFarmacia);
                $records->bindParam(':IdPeriodo',$this->idPeriodo);
                $records->bindParam(':IdObraSocial',$this->idObraSocial);
                $records->bindParam(':Recetas',$this->recetas);
                $records->bindParam(':Recaudado',$this->recaudado);
                $records->bindParam(':AcargoOS',$this->aCargoOS);
                $records->bindParam(':Bonificacion',$this->bonificacion);
                $records->bindParam(':Observaciones',$this->observaciones);
                $records->bindParam(':user',$this->userAdd);
                $records->execute();

                $conn->commit();

                $this->id = $conn->lastInsertId();
                return $this->id;
            } catch(PDOException $e){
                $conn->rollBack();
                throw new Exception($e->getMessage());
                return false;
            }
        }

        /*eliminar receta (es necesario que el objeto este instanceado) */
        public function delete(){
            if($this->id == null){
                $error_msg = "Error al eliminar receta: el id no puede ser nulo";
                throw new Exception($error_msg);
            }

            $conn = db::connect();
            $sql = "UPDATE recetas_web
                    SET 
                        Eliminado = 1,
                        DateDel = GETDATE(),
                        UserDel = :user,
                        WebSyncStatus = iif(WebSyncStatus = 1, 1, 2)
                    WHERE Id = :Id
            ";
            $records = $conn->prepare($sql);
            try{
                $conn->beginTransaction();
                
                $records->bindParam(':Id',$this->id);
                $records->bindParam(':user',$this->userDel);
                $records->execute();

                $conn->commit();
                return true;
            } catch(PDOException $e){
                $conn->rollBack();
                throw new Exception($e->getMessage());
                return false;
            }
        }

        /* get all records */
        public static function getAll()
        {
            $conn = db::connect();
            $sql = "SELECT * FROM Recetas_web";
            $stmt = $conn->query($sql);
            $result = $stmt->fetchAll();
            $recetas = array();
            foreach($result as $row){
                $receta = new Receta();
                $receta->id = $row['ID'];
                $receta->fecha = $row['DateAdd'];
                $receta->idPeriodo = $row['IdPeriodo'];
                $receta->idFarmacia = $row['IdFarmacia'];
                $receta->idObraSocial = $row['IdObraSocial'];
                $receta->recetas = $row['Recetas'];
                $receta->recaudado = $row['Recaudado'];
                $receta->aCargoOS = $row['AcargoOS'];
                $receta->bonificacion = $row['Bonificacion'];
                $receta->observaciones = $row['Observaciones'];
                $receta->userAdd = $row['UserAdd'];
                $receta->userDel = $row['UserDel'];
                array_push($recetas,$receta);
            }

            return $recetas;
        }
        
        /* obtener por id farmacia y periodo */
        public static function getBy($idFarmacia, $idPeriodo, $idObraSocial){
            $conn = db::connect();
            $sql = "SELECT * FROM Recetas_web
                WHERE 
                    Eliminado = 0 AND 
                    IdFarmacia = :IdFarmacia AND 
                    IdPeriodo = :IdPeriodo AND 
                    IdObraSocial = :IdObraSocial
                ";
            $records = $conn->prepare($sql);
            $records->bindParam(':IdFarmacia',$idFarmacia);
            $records->bindParam(':IdPeriodo',$idPeriodo);
            $records->bindParam(':IdObraSocial',$idObraSocial);
            $records->execute();
            $result = $records->fetchAll(PDO::FETCH_ASSOC);

            $recetas = array();
            foreach($result as $row){
                $receta = new Receta();
                $receta->id = $row['ID'];
                $receta->fecha = $row['DateAdd'];
                $receta->idPeriodo = $row['IdPeriodo'];
                $receta->idFarmacia = $row['IdFarmacia'];
                $receta->idObraSocial = $row['IdObraSocial'];
                $receta->recetas = $row['Recetas'];
                $receta->recaudado = $row['Recaudado'];
                $receta->aCargoOS = $row['AcargoOS'];
                $receta->bonificacion = $row['Bonificacion'];
                $receta->observaciones = $row['Observaciones'];
                $receta->userAdd = $row['UserAdd'];
                $receta->userDel = $row['UserDel'];
                array_push($recetas,$receta);
            }
            return $recetas;
        }

        /* agrupa todas la recetas del mismo periodo y farmacia */
        public static function getGrouped($idFarmacia, $idPeriodo, $idObraSocial){
            $conn = db::connect();
            $sql = "SELECT
                IdFarmacia,
                IdPeriodo,
                IdObraSocial,
                sum(Recetas) as Recetas,
                sum(Recaudado) as Recaudado,
                sum(AcargoOS) as AcargoOS,
                sum(Bonificacion) as Bonificacion
            FROM recetas_web 
            WHERE Eliminado = 0 AND IdPeriodo = :IdPeriodo AND IdFarmacia = :IdFarmacia AND IdObraSocial = :IdObraSocial
            GROUP BY IdFarmacia, IdPeriodo, IdObraSocial
            ";
            $records = $conn->prepare($sql);
            $records->bindParam(':IdFarmacia',$idFarmacia);
            $records->bindParam(':IdPeriodo',$idPeriodo);
            $records->bindParam(':IdObraSocial',$idObraSocial);
            $records->execute();
            $result = $records->fetch(PDO::FETCH_ASSOC);

            $receta = new Receta();
            $receta->idPeriodo = $idPeriodo;
            $receta->idFarmacia = $idFarmacia;
            $receta->idObraSocial = $idObraSocial;
            $receta->recetas = isset($result['Recetas']) ? $result['Recetas'] : 0;
            $receta->recaudado = isset($result['Recaudado']) ? $result['Recaudado'] : 0.00;
            $receta->aCargoOS = isset($result['AcargoOS']) ? $result['AcargoOS'] : 0.00;
            $receta->bonificacion = isset($result['Bonificacion']) ? $result['Bonificacion'] : 0.00;

            return $receta;
        }

        /* static delete by id */
        public static function staticDelete($id, $userDel = null){
            $conn = db::connect();
            $sql = "UPDATE recetas_web
                    SET 
                        Eliminado = 1,
                        UserDel = :user,
                        DateDel = GETDATE(),
                        WebSyncStatus = iif(WebSyncStatus = 1, 1, 2)
                    WHERE Id = :Id
            ";
            $records = $conn->prepare($sql);
            try{
                $conn->beginTransaction();
                
                $records->bindParam(':Id',$id);
                $records->bindParam(':user',$userDel);
                $records->execute();

                $conn->commit();
                return true;
            } catch(PDOException $e){
                $conn->rollBack();
                throw new Exception($e->getMessage());
                return false;
            }
        }     
    }
?>