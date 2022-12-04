<?php
    include "../../conexion.php";

    $nombre_afiliado= $_POST['nombre'];
    $nro_afiliado= $_POST['numero-afil'];
    $nro_asociado= $_POST['n-asoc'];
    $dni= $_POST['dni'];
    $fecha = $_POST['fecha'];

    $sql = "INSERT INTO afiliados(
        nombre,
        nro_afiliado,
        dni,
        fecha_nacimiento,
        nro_asociado) VALUES (
        '$nombre_afiliado',
        '$nro_afiliado',
        '$dni',
        '$fecha',
        '$nro_asociado')";
    
    //echo $sql;

    mysqli_query($cnx_mysqli,$sql);
    
    //echo 'se creo el afiliado';

        header("location:../afiliados-lista.php");
        ?>