<?php 
//CONEXIÓN------------------------------------------------------------
    include_once("../../conexion.php"); //poner esto en un archivo
    $numafiliado = $_POST['id-afiliado'];
    $sql="SELECT id_afiliado, CONCAT(nro_afiliado,'-',nro_asociado) AS datosafiliado, nombre as nombrecompleto, dni, fecha_nacimiento, nro_afiliado
    FROM afiliados
    WHERE eliminado = 0 AND nro_afiliado = $numafiliado;";


    $resultado=mysqli_query($cnx_mysqli,$sql);

    $rows=array();

    while($r=mysqli_fetch_assoc($resultado)){
      $rows[]=$r;
    }
    

    //echo json_encode($rows);

    echo json_encode(utf8_converter($rows));

    ?>