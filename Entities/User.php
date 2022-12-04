<?php 
    include_once(dirname(__FILE__)."/db.php");
    include_once(dirname(__FILE__)."/Farmacia.php");
    /* class for handle user */
    class User{
        public $id;
        public $username;
        public $email;
        private $password;
        public $imagen;
        //public $idFarmacia;
        //public $Farmacia;
        public $Notificaciones;
        public $farmacias;
        public $permisos;
        private $admin;
        public $farmaciaSeleccionada;

        public function __construct(){

        }

        /* Si existe usuario en la session llena el objeto con el usuario correspondiente */
        public function setWithSession(){
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (isset($_SESSION['user'])) {
                $SessionUser = unserialize($_SESSION['user']);
                $this->id = $SessionUser->id;
                $this->username = $SessionUser->username;
                $this->email = $SessionUser->email;
                $this->imagen = $SessionUser->imagen;
                //$this->idFarmacia = $SessionUser->idFarmacia;
                $this->permisos = $SessionUser->permisos;
                $this->admin = $SessionUser->admin;
                $this->farmacias = $SessionUser->farmacias;
                $this->farmaciaSeleccionada = $SessionUser->farmaciaSeleccionada;
            }
        }

        public function changePassword($oldPassword, $newPassword){
            if(
                $this->id == null
            ){
                $error_msg = "Error al cambiar contraseña: valores nulos \n 
                (id de usuario)";
                throw new Exception($error_msg);
            }

            if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,}$/', $newPassword) == 0) {
                $error_msg = "Error al cambiar contraseña: contraseña invalida \n 
                (contraseña debe tener al menos 8 caracteres, una letra y un numero)";
                throw new Exception($error_msg);
            }

            $conn = db::connect();
            $sql = "UPDATE UsuariosWeb SET Password = :newPassword WHERE Id = :id AND Password = :oldPassword";
            $records = $conn->prepare($sql);

            try{
                $conn->beginTransaction();
                $oldHash = strtoupper(hash('sha512', $oldPassword));
                $newHash = strtoupper(hash('sha512', $newPassword));
                $records->bindParam(':id',$this->id);
                $records->bindParam(':oldPassword',$oldHash);
                $records->bindParam(':newPassword',$newHash);
                $records->execute();

                $conn->commit();
               
                if ($records->rowCount() > 0) {
                    return true;
                } else {
                    $error_msg = "Ocurrio un error al cambiar contraseña \n 
                    verifique que la contraseña actual sea correcta o intentelo más tarde. ";
                    throw new Exception($error_msg);
                }
            } catch(PDOException $e){
                $conn->rollBack();
                throw new Exception($e->getMessage());
                return false;
            }
        }

        public function changeUsername($username){
            if(
                $this->id == null
            ){
                $error_msg = "Error al cambiar username: valores nulos \n 
                (id de usuario)";
                throw new Exception($error_msg);
            }

            if (preg_match('/^[a-zA-Z0-9]+$/', $username) == 0) {
                $error_msg = "Error al cambiar nombre usuario: no se aceptan espacios ni caracteres especiales.";
                throw new Exception($error_msg);
            }

            $conn = db::connect();
            $sql = "UPDATE UsuariosWeb SET Username = :username1 WHERE Id = :id and (select count(*) from UsuariosWeb where Username = :username2) = 0";
            $records = $conn->prepare($sql);

            try{
                $conn->beginTransaction();

                $records->bindParam(':id',$this->id);
                $records->bindParam(':username1',$username);
                $records->bindParam(':username2',$username);
                $records->execute();

                $conn->commit();
               
                if ($records->rowCount() > 0) {
                    $this->username = $username;
                    $_SESSION['user'] = serialize($this);
                    return true;
                } else {
                    $error_msg = "Error al cambiar nombre usuario: el nombre ya está siendo utilizado.";
                    throw new Exception($error_msg);
                }
            } catch(PDOException $e){
                $conn->rollBack();
                throw new Exception($e->getMessage());
                return false;
            }
            return false;
        }

        public function changeImage($image){
            if(
                $this->id == null
            ){
                $error_msg = "Error al cambiar imagen: valores nulos \n 
                (id de usuario)";
                throw new Exception($error_msg);
            }

            $conn = db::connect();
            $sql = "UPDATE UsuariosWeb SET Imagen = :image WHERE Id = :id";
            $records = $conn->prepare($sql);

            try{
                $conn->beginTransaction();

                $records->bindParam(':id',$this->id);
                $records->bindParam(':image',$image);
                $records->execute();

                $conn->commit();
               
                if ($records->rowCount() > 0) {
                    $this->imagen = $image;
                    $_SESSION['user'] = serialize($this);
                    return true;
                } else {
                    $error_msg = "Error al cambiar imagen: intentelo más tarde.";
                    throw new Exception($error_msg);
                }
            } catch(PDOException $e){
                $conn->rollBack();
                throw new Exception($e->getMessage());
                return false;
            }
            return false;
        }

        //Create new sub user (assistant) - the admin user must be logged in
        public function createSubUser($username, $password, $email){
            if(
                $this->id == null
            ){
                $error_msg = "Error al crear usuario: valores nulos \n 
                (id de usuario)";
                throw new Exception($error_msg);
            }

            if(
                $this->admin == 0
            ){
                $error_msg = "Error al crear usuario: el usuario no es administrador";
                throw new Exception($error_msg);
            }
            

            if (preg_match('/^[a-zA-Z0-9]+$/', $username) == 0) {
                $error_msg = "Error al crear usuario: no se aceptan espacios ni caracteres especiales.";
                throw new Exception($error_msg);
            }

            if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,}$/', $password) == 0) {
                $error_msg = "Error al crear usuario: contraseña invalida \n 
                (contraseña debe tener al menos 8 caracteres, una letra y un numero)";
                throw new Exception($error_msg);
            }

            if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                $error_msg = "Error al crear usuario: email invalido";
                throw new Exception($error_msg);
            }

            $conn = db::connect();
            $sql = "IF NOT EXISTS (SELECT 1 FROM UsuariosWeb WHERE Username = :username1)
                    BEGIN
                        INSERT INTO UsuariosWeb (Username, [Password], Email, Imagen, IdOwner, [DateAdd], Eliminado) 
                        VALUES (:username2, :password, :email, 'default.png', :idOwner, GETDATE(), 0)
                    END
            ";
                
            $records = $conn->prepare($sql);

            try{
                $conn->beginTransaction();
                $strUper = strtoupper($username);
                $hash = strtoupper(hash('sha512', $password));
                $records->bindParam(':username1',$strUper);
                $records->bindParam(':username2',$strUper);
                $records->bindParam(':password',$hash);
                $records->bindParam(':email',$email);
                $records->bindParam(':idOwner',$this->id);
                $records->execute();

                if ($records->rowCount() > 0) {
                    $conn->commit();
                    return true;
                } else {
                    $conn->rollBack();
                    $error_msg = "Error al crear usuario: el nombre de usuario ya está siendo utilizado.";
                    throw new Exception($error_msg);
                }
                
            } catch(PDOException $e){
                $conn->rollBack();
                throw new Exception($e->getMessage());
                return false;
            }
            return false;
        }

        //Delete sub user (assistant) - the admin user must be logged in
        public function deleteSubUser($id, $deleted){
            if(
                $this->id == null
            ){
                $error_msg = "Error al eliminar usuario: valores nulos \n 
                (id de usuario)";
                throw new Exception($error_msg);
            }

            if(
                $this->admin == 0
            ){
                $error_msg = "Error al eliminar usuario: el usuario no es administrador";
                throw new Exception($error_msg);
            }

            $conn = db::connect();
            $sql = "UPDATE UsuariosWeb SET 
                Eliminado = :deleted,
                WebSyncStatus = iif(WebSyncStatus = 1, 1, 2) 
                WHERE Id = :id AND IdOwner = :idOwner
            ";
            $records = $conn->prepare($sql);

            try{
                $conn->beginTransaction();

                $records->bindParam(':id',$id);
                $records->bindParam(':idOwner',$this->id);
                $records->bindParam(':deleted',$deleted);
                $records->execute();

                $conn->commit();
               
                if ($records->rowCount() > 0) {
                    return true;
                } else {
                    $error_msg = "Error al eliminar usuario: el usuario no existe o no pertenece al usuario actual.";
                    throw new Exception($error_msg);
                }
            } catch(PDOException $e){
                $conn->rollBack();
                throw new Exception($e->getMessage());
                return false;
            }
            return false;
        }

        //Get all sub users (assistants) - the admin user must be logged in
        public function getUsers(){
            if(
                $this->id == null
            ){
                $error_msg = "Error al obtener usuarios: valores nulos \n 
                (id de usuario)";
                throw new Exception($error_msg);
            }

            if(
                $this->admin == 0
            ){
                $error_msg = "Error al obtener usuarios: el usuario no es administrador";
                throw new Exception($error_msg);
            }

            $conn = db::connect();
            
            $sql = "SELECT Id, Username, Email, Imagen, IdOwner, [DateAdd], Eliminado FROM UsuariosWeb WHERE IdOwner = :idOwner AND Eliminado = 0";
            $records = $conn->prepare($sql);

            try{
                $conn->beginTransaction();
                $records->bindParam(':idOwner',$this->id);
                $records->execute();
               
                $result = $records->fetchAll(PDO::FETCH_ASSOC);
                $users = [];

                foreach($result as $row){
                    $usr = new User();
                    $usr->id = $row['Id'];
                    $usr->username = $row['Username'];
                    $usr->email = $row['Email'];
                    $usr->imagen = $row['Imagen'];
                    $usr->idOwner = $row['IdOwner'];
                    $usr->dateAdd = $row['DateAdd'];

                    $usr->setFarmacias();

                    array_push($users, $usr);
                }

                $conn->commit();

                return $users;

            } catch(PDOException $e){
                $conn->rollBack();
                throw new Exception($e->getMessage());
                return false;
            }
            return false;
        }


        private function setFarmacias(){
            if(
                $this->id == null
            ){
                $error_msg = "Error al obtener farmacias: valores nulos \n 
                (id de usuario)";
                throw new Exception($error_msg);
            }

            $conn = db::connect();
            $sql = "SELECT u.IdFarmacia, f.Nombre 
                    FROM UsuariosWeb_Farmacias u 
                    JOIN Farmacias f ON f.id = u.IdFarmacia 
                    WHERE u.Eliminado = 0 and IdUsuarioWeb = :id";
            $records = $conn->prepare($sql);

            try{
                $records->bindParam(':id',$this->id);
                $records->execute();
                $result = $records->fetchAll(PDO::FETCH_ASSOC);
                $arrfarmacias = array();
                foreach($result as $row){
                    $farmacia = new Farmacia();
                    $farmacia->id = $row['IdFarmacia'];
                    $farmacia->nombre = $row['Nombre'];
                    array_push($arrfarmacias,$farmacia);
                }
                //$this->farmacias = $records->fetchAll(PDO::FETCH_ASSOC);
                $this->farmacias = $arrfarmacias;
                $this->farmaciaSeleccionada = count($arrfarmacias) > 0 ? $arrfarmacias[0]->id : null;
                //$this->farmaciaSeleccionada = count($this->farmacias) > 0 ? $this->farmacias[0]['IdFarmacia'] : null;
            } catch(PDOException $e){
                throw new Exception($e->getMessage());
                return false;
            }
            return false;
        }

        public function changeSelectedFarmacia($idFarmacia){
            if(
                $this->id == null
            ){
                $error_msg = "Error al cambiar farmacia seleccionada: valores nulos \n 
                (id de usuario)";
                throw new Exception($error_msg);
            }   

            $this->farmaciaSeleccionada = $idFarmacia;

            $_SESSION['user'] = serialize($this);

            return true;
        }

        public function isAdmin(){
            return $this->admin == 1;
        }

        /* static methods: se pueden usar sin necesidad de instanciar clase */
        public static function login($username,$password){
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $conn = db::connect();
            //$sql = "SELECT * FROM UsuariosWeb WHERE Username = :user1 or Email = :user2";
            $sql = "SELECT * FROM UsuariosWeb WHERE Username = :user1 AND Eliminado = 0";
            $records = $conn->prepare($sql);
            $records->bindParam(':user1',$username);
            //$records->bindParam(':user2',$username);
            $records->execute();
            $result = $records->fetch(PDO::FETCH_ASSOC);

            $hashed = strtoupper(hash('sha512', $password));
            
            if($result){

                if (count($result) > 0 && $hashed == $result['Password']) {
                    $user = new User();
                        $user->id = $result['ID'];
                        $user->username = $result['Username'];
                        $user->email = $result['Email'];
                        $user->imagen = $result['Imagen'];
                        //$user->idFarmacia = $result['idFarmacia'];
                        $user->permisos = $result['Permisos'];
                        $user->admin = $result['Admin'];

                        $user->setFarmacias();

                    $_SESSION['user'] = serialize($user);
                    return $user;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }

        public static function logout(){
            
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_destroy();
                return true;
            }
            
        }

        public static function isAuthenticated(){
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (isset($_SESSION['user'])){
                //var_dump($_SESSION);
                return true;
            }
            else{
                return false;
            }
        }

        public static function updateUserFarmacias($userId, $arrFarmacias){
            if(
                $userId == null
            ){
                $error_msg = "Error al actualizar usuario-farmacias: valores nulos \n 
                (id de usuario)";
                throw new Exception($error_msg);
            }
            //1st - deactivate relations for that user
            
            $conn = db::connect();
            $conn->beginTransaction();
            $sql = "UPDATE UsuariosWeb_Farmacias SET 
                Eliminado = 1, 
                WebSyncStatus = iif(WebSyncStatus = 1, 1, 2) 
                WHERE IdUsuarioWeb = :id
            ";
            try{
                $records = $conn->prepare($sql);
                $records->bindParam(':id',$userId);
                $records->execute();
            } catch(PDOException $e){
                $conn->rollBack();
                throw new Exception($e->getMessage());
                return false;
            }

            //2nd - update if exists or insert if not

            foreach($arrFarmacias as $farmacia){
                $sql = "SELECT * FROM UsuariosWeb_Farmacias WHERE IdUsuarioWeb = :id and IdFarmacia = :idFarmacia";
                $records = $conn->prepare($sql);
                $records->bindParam(':id',$userId);
                $records->bindParam(':idFarmacia',$farmacia);
                $records->execute();
                $result = $records->fetch(PDO::FETCH_ASSOC);

                if($records->rowCount() > 0){
                    $sql = "UPDATE UsuariosWeb_Farmacias SET Eliminado = 0 WHERE IdUsuarioWeb = :id and IdFarmacia = :idFarmacia";
                    try{
                        $records = $conn->prepare($sql);
                        $records->bindParam(':id',$userId);
                        $records->bindParam(':idFarmacia',$farmacia);
                        $records->execute();
                    } catch(PDOException $e){
                        $conn->rollBack();
                        throw new Exception($e->getMessage());
                        return false;
                    }
                }
                else{
                    $sql = "INSERT INTO UsuariosWeb_Farmacias (IdUsuarioWeb, IdFarmacia, Eliminado) VALUES (:id, :idFarmacia, 0)";
                    try{
                        $records = $conn->prepare($sql);
                        $records->bindParam(':id',$userId);
                        $records->bindParam(':idFarmacia',$farmacia);
                        $records->execute();
                    } catch(PDOException $e){
                        $conn->rollBack();
                        throw new Exception($e->getMessage());
                        return false;
                    }
                }
            }
            $conn->commit();
            return true;
        }
    }

?>