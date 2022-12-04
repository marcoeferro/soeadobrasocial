<?php

//MySQL
$host='localhost';
$dbname='c2521279_base'; //nombre de la base de datos
$username='c2521279_base'; //usuario de la base de datos
$pasword ='ZEbifa33ni';   //contraseña de la base de datos
$puerto=3306; //El puerto por defecto es 3306 pero en mi caso yo uso el 3307 CAMBIARLO AL PUERTO POR DEFECTO PARA QUE FUNCIONE!!! --NOTA CLAUDIO


// Nos conectamos a la BBDD
//$conn = new PDO( 'mysql:host='.$host.';dbname='.$dbname.';port='.$puerto.'', $username, $pasword);
$conn = new PDO( 'mysql:host='.$host.';dbname='.$dbname.';port='.$puerto.'', $username, $pasword);
    
?>