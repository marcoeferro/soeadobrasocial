<?php
    include "../../conexion.php";

    $nombre_centro= $_POST['nombre'];
    $direccion_centro= $_POST['direccion'];
    $telefono_centro= $_POST['telefono'];
    $id_ciudad= $_POST['ciudad'];
    
    

    $sql3 = "INSERT INTO centros(
        nombre,
        id_ciudad,
        direccion,
        telefono) VALUES (
        '$nombre_centro',
        '$id_ciudad',
        '$direccion_centro',
        '$telefono_centro'
        )";

    mysqli_query($cnx_mysqli,$sql3);
    

        header("location:../home.php");
        ?>
