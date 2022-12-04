<?php 
    include_once(dirname(__FILE__)."/db.php");

    class Farmacia{
        public $id;
        public $codigo;
        public $nombre;
        public $razonSocial;
        public $preferenciaPago;
        public $cbu;
        public $cuit;
        public $domicilio;
        public $telefono;
        public $email;

        public function __construct(){}

        /* get all records */
        public static function getAll(){
            $conn = db::connect();
            $sql = "SELECT 
                    ID,
                    Codigo,
                    Nombre,
                    RazonSocial,
                    PreferenciaPago,
                    Cbu,
                    Cuit,
                    Domicilio,
                    Telefono,
                    Email
                FROM farmacias
                WHERE Eliminado = 0"
            ;
            $stmt = $conn->query($sql);
            $result = $stmt->fetchAll();
            $farmacias = array();
            foreach($result as $row){
                $farmacia = new Farmacia();
                $farmacia->id = $row['ID'];
                $farmacia->codigo = $row['Codigo'];
                $farmacia->nombre = $row['Nombre'];
                $farmacia->razonSocial = $row['RazonSocial'];
                $farmacia->preferenciaPago = $row['PreferenciaPago'];
                $farmacia->cbu = $row['Cbu'];
                $farmacia->cuit = $row['Cuit'];
                $farmacia->domicilio = $row['Domicilio'];
                $farmacia->telefono = $row['Telefono'];
                $farmacia->email = $row['Email'];
                array_push($farmacias,$farmacia);
            }
            return $farmacias;
        }
         
        public static function getById($id){
            $conn = db::connect();
            $sql = "SELECT 
                    ID,
                    Codigo,
                    Nombre,
                    RazonSocial,
                    PreferenciaPago,
                    Cbu,
                    Cuit,
                    Domicilio,
                    Telefono,
                    Email
                FROM farmacias
                WHERE ID = :id
                AND Eliminado = 0"
            ;
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $result = $stmt->fetch();
            $farmacia = new Farmacia();
            $farmacia->id = $result['ID'];
            $farmacia->codigo = $result['Codigo'];
            $farmacia->nombre = $result['Nombre'];
            $farmacia->razonSocial = $result['RazonSocial'];
            $farmacia->preferenciaPago = $result['PreferenciaPago'];
            $farmacia->cbu = $result['Cbu'];
            $farmacia->cuit = $result['Cuit'];
            $farmacia->domicilio = $result['Domicilio'];
            $farmacia->telefono = $result['Telefono'];
            $farmacia->email = $result['Email'];
            return $farmacia;
        }
    }
?>