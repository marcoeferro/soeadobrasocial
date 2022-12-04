<?php
    include "../../conexion.php";

    $nombre_ciudad= $_POST['nombre'];
    $codigo_postal_ciudad= $_POST['codigo-postal'];
    $departamento_ciudad= $_POST['departamento'];
    
    

    $sql3 = "INSERT INTO ciudades(
        nombre,
        codigo_postal,
        departamento) VALUES (
        '$nombre_ciudad',
        '$codigo_postal_ciudad',
        '$departamento_ciudad'
        )";

    mysqli_query($cnx_mysqli,$sql3);
    

    header("location:../nuevo-centro.php");
    ?>
