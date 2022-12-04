<?php
    include("../../conexion.php");
                $sql = "UPDATE autorizaciones SET id_estado=1
            WHERE id_autorizacion = " . $_POST['vienedelform'] ;
            mysqli_query($cnx_mysqli,$sql);

        header("location: ../home.php");
        ?>


