<?php
    include("../../conexion.php");
                $sql = "UPDATE autorizaciones SET id_estado=3
            WHERE id_autorizacion = " . $_POST['vienedelform'] ;
            mysqli_query($cnx_mysqli,$sql);

            //echo $sql;
            //echo 'lgo';
            
            
        header("location:../home.php");
        ?>

            
