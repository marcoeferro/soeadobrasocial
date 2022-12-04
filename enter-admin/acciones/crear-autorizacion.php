<?php
include_once("../../conexion.php");

    $num_afiliado = $_POST['seleccionAfiliado'];
    $num_asociado = $_POST['seleccionFamiliar'];
    $idprestador = $_POST['seleccionPrestador'];
    $matricula_prestador = $_POST['seleccionPrestador'];
    $nombre = $_POST['descripcion'];
    $fecha = date("Y-m-d");

     $sql_afiliado ="SELECT id_afiliado FROM afiliados WHERE nro_afiliado = " . $num_afiliado . " AND nro_asociado = " . $num_asociado;
    // echo $sql_afiliado;
    
    $lista_afiliado = mysqli_query($cnx_mysqli,$sql_afiliado);
    while($afiliado=mysqli_fetch_array($lista_afiliado)){
        $id_afiliado = $afiliado['id_afiliado'];
    }

    $id_prestador=0;

    if(isset($matricula_prestador)){
        $sql_prestador="SELECT id_prestador FROM prestadores WHERE nombre = '" . $matricula_prestador . "'";
     $prestador_id=mysqli_query($cnx_mysqli,$sql_prestador);
     while($prestador=mysqli_fetch_array($prestador_id)){
        $id_prestador = $prestador['id_prestador'];
    }
    }
 

    $sql="INSERT INTO autorizaciones
    (
    id_afiliado,
    id_prestador,
    id_estado,
    id_administrador,
    nombre,
    fecha_aprobacion,
    fecha_caducidad)
    VALUES
    (
    $id_afiliado,
    $id_prestador,
    2,
    1,
    '$nombre',
    '$fecha',
    DATE_ADD('$fecha', INTERVAL 30 DAY));";
    //echo $sql;


    mysqli_query($cnx_mysqli,$sql);

       header("location:../home.php");
        ?>