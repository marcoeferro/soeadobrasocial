<?php
    include "../../conexion.php";

    $especialidad_prestador = $_POST['especialidad'];
    $nombre_prestador = $_POST['nombre'];
    $centro_prestador = $_POST['centro'];

    $sql1 = "INSERT INTO prestadores(
        nombre,
        id_centro) VALUES (
        '$nombre_prestador',
        '$centro_prestador')";
       // echo $sql1;
    
    mysqli_query($cnx_mysqli,$sql1);

    $sql2= "SELECT id_prestador FROM prestadores ORDER BY id_prestador DESC LIMIT 1";
    $result= mysqli_query($cnx_mysqli,$sql2);
    $id=mysqli_fetch_row($result);
    $id_prestador = $id[0];
    //var_dump($id);
    //echo $sql2;

    foreach($especialidad_prestador as &$idEspecialidad){
        $sql3 = "INSERT INTO prestadores_especialidad(
            idEspecialidad,
            idPrestador) VALUES (
            '$idEspecialidad',
            '$id_prestador')";
    
            //echo $sql3;
    
        mysqli_query($cnx_mysqli,$sql3);
    }

            
    header("location:../prestadores-lista-administrador.php")
    ?> 