<?php
    include "../../conexion.php";

    $id=$_POST['id'];
    $especialidad_prestador = $_POST['especialidad'];
    $centro_prestador = $_POST['centro'];
    $nombre = $_POST['nombre'];

    $sql = "UPDATE prestadores SET nombre = '$nombre', apellido = '$apellido', matricula='$matricula'
    WHERE id_prestador = $id";

    //echo $sql;

    mysqli_query($cnx_mysqli,$sql);

    //var_dump($id);
    //echo $sql2;

    foreach($especialidad_prestador as &$idEspecialidad){
        $sql3 = "INSERT INTO prestadores_especialidad(
            idEspecialidad,
            idPrestador) VALUES (
            '$idEspecialidad',
            '$id')";
    
            //echo $sql3;
    
        mysqli_query($cnx_mysqli,$sql3);
    }
    
    
        header("location:../prestadores-lista-administrador.php");
        ?>
