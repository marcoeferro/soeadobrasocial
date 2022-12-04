<?php
    include "../../conexion.php";

    $nombre_admin= $_POST['nombre'];
    $apellido_admin= $_POST['apellido'];
    $puesto_admin= $_POST['n-admin'];
    $Usuario= $_POST['usuario'];
    $Password= $_POST['password'];
    $email = $_POST['email'];

    $sql = "INSERT INTO administradores(
        nombre,
        apellido,
        puesto,
        Usuario,
        Password,
        mail) VALUES (
        '$nombre_admin',
        '$apellido_admin',
        '$puesto_admin',
        '$Usuario',
        '$Password',
        '$email'
        )";
    //echo $sql;

    mysqli_query($cnx_mysqli,$sql);
    

        header("location:../home.php");
        ?>
