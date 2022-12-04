<?php 
//CONEXIÓN------------------------------------------------------------
    include_once("../../conexion.php"); //poner esto en un archivo
    $sql="SELECT CONCAT(c.direccion,' - ',ci.nombre) as matri, p.id_prestador as idp,
    p.nombre as nombrePrestador, p.apellido as ap, c.telefono as telCentro,  
    e.nombre as nombreEspecialidad, c.nombre as nombreCentro
    FROM prestadores p JOIN prestadores_especialidad pe ON p.id_prestador = pe.IdPrestador 
    JOIN especialidades e ON e.id_especialidad = pe.IdEspecialidad 
    JOIN centros c ON c.id_centro = p.id_centro 
    JOIN ciudades ci ON ci.id_ciudad = c.id_ciudad
    WHERE p.eliminado=0
    ORDER BY nombreEspecialidad";


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