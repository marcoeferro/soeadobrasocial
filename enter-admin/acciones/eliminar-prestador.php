<?php //HACE FALTA CAMBIAR MODO DE ELIMINACIÓN
    include "../../conexion.php";

    $id =  $_POST['vienedelform'];

    $sql = "UPDATE prestadores p SET p.eliminado = 1 WHERE id_prestador = $id";

    mysqli_query($cnx_mysqli,$sql);


        header("location:../prestadores-lista-administrador.php");
        ?>