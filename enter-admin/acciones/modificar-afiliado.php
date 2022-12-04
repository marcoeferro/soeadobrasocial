<?php
    include "../../conexion.php";
    $nombre_afiliado= $_POST['nombre'];
    $nro_afiliado= $_POST['numAfil'];
    $dni= $_POST['dni'];
    $id= $_POST['id'];
    $fecha = $_POST['fnacimiento'];

    $sql = "UPDATE afiliados a SET a.nombre = '$nombre_afiliado', a.nro_afiliado =$nro_afiliado, a.dni = $dni,a.fecha_nacimiento='$fecha'
    WHERE a.id_afiliado = $id";

    //echo $sql;

    mysqli_query($cnx_mysqli,$sql);
    
    //echo 'se modificaron los datos';
    
        header("location:../afiliados-lista.php");
        ?>

