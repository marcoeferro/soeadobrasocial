<?php
$email = $_POST['email'];
    include_once("./conexion.php");

    $sql_admin="SELECT a.mail, a.Usuario as usuario, a.Password as contrasenia FROM administradores a
    WHERE a.mail = '$email' ";


    $resultado=mysqli_query($cnx_mysqli,$sql_admin);

    $filas=mysqli_num_rows($resultado);

    while($mostrar=mysqli_fetch_array($resultado)){
        $usuario = $mostrar['usuario'];
        $contasenia = $mostrar['contrasenia'];
    }

    $to = $email;
    $subject = "Ingreso a SOEAD Salud";
    $message = "
    <html>
    <head>
    <title>HTML</title>
    </head>
    <body style='background: lightgreen; position: centered;'>
    <h1>Recuperación de cuenta</h1>
    <p>Los datos de ingreso a tu cuenta son los siguientes:<br>Usuario: " . $usuario ."<br>Constraseña: " . $contasenia . "<br>
    <a href:'http://sindicatoaceitero.com.ar/osocial/login-administrador.php'>Ingreso a la gestión</a>
    <br>Ante cualquier inconveniente comunicarse con Kaizen Software.</p>
    </body>
    </html>";
    //echo $message;
    $headers = "Content-type:text/html;charset=UTF-8" . "\r\n" . "From: empresas@sindicatoaceitero.com.ar";

    if($filas){
        mail($email,$subject,$message,$headers);
       if(  mail($email,$subject,$message,$headers)){
        ?>
        <div style="width:100%; background-color:lightgreen;border:solid green;padding-left: 15px;">
        <h4 style="align-content:center;">Revise su casilla de correo.</h4>
    </div>
        <?php
        include("./login-administrador.php");
        ?>
        <?php

       }
    } else {
        ?>
        <div style="width:100%; background-color:lightcoral;border:solid red;">
        <h4 style="align-content:center ;">La dirección de correo no corresponde a un administrador registrado.</h4>
    </div>
        <?php
        include("./recuperar-usuario.php");
        ?>
        <?php
    }
    mysqli_free_result($resultado);
    mysqli_close($cnx_mysqli);

    ?>
