<?php

class db{
    public static function connect(){

        //PRUEBAS

        
        $host='LAPTOP-7N54SP11';
        $dbname='CENPROFAR';
        $username='sa';
        $pasword ='industrial';
        $puerto=1433;
        

        //PRODUCCION
        
        /* $host='sql2016';
        $dbname='w280432_CPF';
        $username='w280432_cpf';
        $pasword ='Al3d3sm4';
        $puerto=1433; */

        try{
            //$conn = new PDO ("sqlsrv:Server=$host,$puerto;Database=$dbname",$username,$pasword);
            $conn = new PDO ("sqlsrv:Server=$host;Database=$dbname",$username,$pasword);
            //echo "Se conectó correctamente a la base de datos"; 
        }
        catch(PDOException $exp){
            echo ("No se logró conectar correctamente con la base de datos: $dbname, error: $exp");
        }
        
        return $conn;
    }
}

?>