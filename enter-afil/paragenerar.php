<?php //CONEXIÓN------------------------------------------------------------
        session_start();
        include_once("../conexion.php");
        
    
    if (!isset($_SESSION['usuario'])) {
        header('location: ../index.php');
    } else {
        $nro_afiliado=$_SESSION['usuario'];

        
        $sql = "SELECT nombre as nombrecompleto, nro_afiliado, nro_asociado FROM afiliados WHERE nro_afiliado = $nro_afiliado;";

        $resultado=mysqli_query($cnx_mysqli,$sql);
         }

    ?>