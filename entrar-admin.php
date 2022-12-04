<?php

$usuario = $_POST['admin'];
$contrasenia = $_POST['pass'];

    session_start();
    

    include_once("./conexion.php");

    $sql = "SELECT a.Usuario,a.Password FROM administradores a 
    WHERE a.Usuario = '$usuario' AND a.Password = '$contrasenia'";

    $resultado=mysqli_query($cnx_mysqli,$sql);

    $filas=mysqli_num_rows($resultado);

    if($filas>0){
        $_SESSION['admin']=$usuario;
        header("location: ./enter-admin/home.php");
    } else {
        ?>
        <div style="width:100%; background-color:lightcoral;border:solid red;">
        <h4 style="align-content:center ;">ERROR al ingresar. Revisar datos.</h4>
    </div>
        <?php
        include("./login-administrador.php");
        ?>
        <?php
    }
    mysqli_free_result($resultado);
    mysqli_close($cnx_mysqli);

    ?>