<?php 
//CONEXIÓN------------------------------------------------------------
    include_once("../../conexion.php"); //poner esto en un archivo
    $sql="SELECT a.nombre as names, 
        DATE_FORMAT(a.fecha_aprobacion,'%d/%m/%Y') as fecha1,
        DATE_FORMAT(a.fecha_caducidad,'%d/%m/%Y') as fecha2, 
        IF (a.id_prestador!=0,p.nombre,'-') as prestador,
        e.nombre as estado,
        a.id_autorizacion as idAutorizacion, 
        af.nombre as nbre_afil
    FROM autorizaciones a
    JOIN prestadores p ON p.id_prestador = a.id_prestador
    JOIN estados e ON e.id_estado = a.id_estado 
    JOIN afiliados af WHERE a.id_afiliado = af.id_afiliado
    ORDER BY fecha1 DESC
    ";
   // echo $sql;


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