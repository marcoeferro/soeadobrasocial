<?php
session_start();

$usuario = $_POST['usuario'];
$contrasenia = $_POST['pass'];

    ob_start();
    
    $_SESSION['usuario']=$usuario;

    include_once("conexion.php");

    $sql = "SELECT a.nro_afiliado,a.dni, a.nombre, a.apellido, a.id_afiliado FROM afiliados a 
    WHERE a.nro_afiliado = '$usuario' AND a.dni = '$contrasenia' AND nro_asociado = 0 AND eliminado=0";

    //echo $sql;

    $resultado=mysqli_query($cnx_mysqli,$sql);

    $filas=mysqli_num_rows($resultado);

    $res=mysqli_query($cnx_mysqli,$sql, MYSQLI_USE_RESULT);
    if ($res) {
        while ($row = mysqli_fetch_row($res)) {
            $nro_afiliado = $row[0];
            $dni = $row[1];
            $nombre = $row[2];
            $apellido = $row[3];
            $nro_asociado = $row[4];
            $id_afiliado = $row[5];

            // echo $nro_afiliado;
            // echo "<br>";
            // echo $dni;
            // echo "<br>";

            $_SESSION['usuarioLogin']['nroAfiliado']=$nro_afiliado;
            $_SESSION['usuarioLogin']['dni']=$dni;
            $_SESSION['usuarioLogin']['nombre']=$nombre;
            $_SESSION['usuarioLogin']['apellido']=$apellido;
            $_SESSION['usuarioLogin']['idAfiliado']=$id_afiliado;
        }
    }
    
    if($filas){
        header("location: ./enter-afil/home.php");
        exit();
    } else {
        ?>
        <div style="width:100%; background-color:lightcoral;border:solid red;">
        <h4 style="align-content:center ;">ERROR al ingresar. Revisar datos.</h4>
        </div>
        <?php
        include("./login-afiliado.php");
        ?>
        <?php
    }
    mysqli_free_result($resultado);
    mysqli_close($cnx_mysqli);

    ?>
