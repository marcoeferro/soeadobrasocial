<?php 
//CONEXIÓN------------------------------------------------------------
    include_once("../../conexion.php"); //poner esto en un archivo
    $sql="SELECT  a.nombre as datosafiliado,
    CONCAT(a.nro_afiliado,'-',a.nro_asociado) as numeroafiliado,
    o.id_orden_consulta as idorden,
    o.fecha as fechapedida,
    o.FechaCancelada as fechaCancelada,if(o.Cancelada,CONCAT('Pagada el ',DATE_FORMAT(o.FechaCancelada,'%d/%m/%Y')),'Falta pago') as estado,o.Cancelada as cancelacion
    FROM ordenesdeconsulta o
    JOIN afiliados a ON o.idAfiliado = a.id_afiliado 
    WHERE o.eliminado = 0
    ORDER BY fechapedida DESC";

    $resultado=mysqli_query($cnx_mysqli,$sql);

    $rows=array();

    //while($r=mysqli_fetch_assoc($resultado)){
      //  echo $r['idp'] . " -- ";
    //}

    while($r=mysqli_fetch_assoc($resultado)){
      $rows[]=$r;
    }

    //echo json_encode($rows);

    echo json_encode(utf8_converter($rows));

    ?>