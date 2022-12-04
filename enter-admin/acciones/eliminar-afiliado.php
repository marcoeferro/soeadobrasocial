<?php
    include "../../conexion.php";

    $id =  $_POST['vienedelform'];

    $sql = "UPDATE afiliados a SET a.eliminado = 1 WHERE a.id_afiliado = $id";

    mysqli_query($cnx_mysqli,$sql);

    header("location:../afiliados-lista.php");
   
    ?>