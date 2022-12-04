<?php
    include("../../conexion.php");

    if($_GET['valor']==1){
        $sql = "UPDATE ordenesdeconsulta SET Cancelada=0
            WHERE id_orden_consulta = " . $_POST['chequealo'] ;
    }else{
        $sql = "UPDATE ordenesdeconsulta SET Cancelada=1,FechaCancelada= CURDATE() 
        WHERE id_orden_consulta = " . $_POST['chequealo'] ;
    }
           // echo $sql;
            mysqli_query($cnx_mysqli,$sql);

        header("location: ../ordenes.php");
        ?>


