<?php
    session_start();
    include_once("../conexion.php");

    $nroasociado = $_POST['numero'];
    $nroafiliado = $_SESSION['usuario'];

    $consulta = "SELECT id_afiliado FROM afiliados WHERE nro_afiliado =  $nroafiliado AND nro_asociado = $nroasociado"; 
    //echo $server;

    $afiliados = mysqli_query($cnx_mysqli,$consulta);

    while($a=mysqli_fetch_array($afiliados)){
         $idafiliado = $a['id_afiliado'];
    }

    $fecha = date('Y-m-d');


    $sql = "INSERT INTO ordenesdeconsulta(
        idAfiliado,
        fecha) VALUES (
        '$idafiliado',
        '$fecha')";
    
    //echo $sql;

    mysqli_query($cnx_mysqli,$sql);
    
            header("location: ../comprobante/ordenConsulta/index.php?numero=$nroasociado");

        ?>