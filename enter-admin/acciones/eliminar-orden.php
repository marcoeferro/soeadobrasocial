<?php
    include "../../conexion.php";

    $id =  $_POST['vienedelform'];

    $sql = "UPDATE ordenesdeconsulta SET eliminado = 1  WHERE id_orden_consulta = $id";

    mysqli_query($cnx_mysqli,$sql);


        header("location:../ordenes.php");
        ?>