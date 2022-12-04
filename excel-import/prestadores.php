<?php
session_start();
ob_start();
if (!isset($_SESSION['admin'])) {
    header('location: ../index.php');
}
include_once("../conexion.php");
$sql = "SELECT nombre FROM centros";
$RESULTADO = mysqli_query($cnx_mysqli, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <?php header('Content-Type: text/html; charset=utf-8'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
    <meta name="generator" content="Hugo 0.88.1" />

    <title>Importar prestadores</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/jumbotron/" />

    <script src="../js/index.js"></script>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        $(window).load(function() {
            $('#page-loader').fadeOut(500);
        });
    </script>



</head>

<body class="admin">
    <div class="spinner-container" id="page-loader">
        <div class="spring-spinner">
            <div class="spring-spinner-part top">
                <div class="spring-spinner-rotator"></div>
            </div>
            <div class="spring-spinner-part bottom">
                <div class="spring-spinner-rotator"></div>
            </div>
        </div>
    </div>
    <nav class="navbar" style="margin-top: 1vh;">
        <div class="container-fluid">
            <a href="../enter-admin/home.php" class="login-header-logo">SOEAD Salud</a>
            <div class="d-flex">
                <a href="../enter-admin/home.php" class="login-header-button" style="margin-left: 20px;"><button style="padding:8px; background-color:lightslategrey;color:white;">Volver atrás</button></a>
                <a class="login-header-button" style="margin-left: 20px;"><button style="padding:8px; background-color:lightslategrey;color:white;" name="volver atrás" data-bs-toggle="modal" data-bs-target="#closeModal">Cerrar sesión</button></a>
            </div>
        </div>
    </nav>

    <form method="post" action="prestadoresInsert.php" enctype="multipart/form-data" class="form-group">
        <div class="login-container" style="width: 45%;">
            <h2>Importar prestadores</h2>
            <div class="">
                <label for="centros">Seleccione el centro al que pertenecen los prestadores:</label>
                <select name="centros" id="centros">
                    <?php
                    while ($mostrar = mysqli_fetch_array($RESULTADO)) {
                        echo '<option>' . $mostrar['nombre'] . '</option>';
                    }
                    ?>
                </select><br><br>


                <div style="margin-bottom: 10px;">
                    <label for="archivo">Seleccione archivo:</label>
                    <input required type="file" class="btn" name="archivo" id="archivo" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                    <br>
                </div>




                <div class="">
                    <div class="" style="text-align: right;">
                        <button class="login-button" type="submit" id="cargar">Cargar Prestadores</button>
                    </div>
                </div>


            </div>

        </div>
    </form>






    <!-- <script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
  </script> -->
    <div class="footer">
        <a href="https://www.sindicatoaceitero.com.ar" target="_blank" rel="noopener noreferrer">
            <img class="logo" src="../enter-admin/image-2-1-1024x262.png" alt="Kaizen Software Factory - Web Development">
        </a>
        <a href="https://www.osiadsalud.org.ar" target="_blank" rel="noopener noreferrer">
            <img class="logo" src="../enter-admin/logo-osiad-salud.png" alt="Kaizen Software Factory - Web Development">
        </a>
        <p class="copy-right">Copyright &copy; <script>
                document.write(new Date().getFullYear())
            </script> Kaizen All Rights Reserved</p>
        <ul>
            <li>Inicio</li>
            <li id="ayuda-label" style="cursor: pointer;">Ayuda</li>
        </ul>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCenprofar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCenprofarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnCerrarModalX"></button>
                </div>
                <div class="modal-body">
                    <p id="modalContent" class="mb-0"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button-secondary size-10" data-bs-dismiss="modal" id="btnCerrarModal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal segundo-->
    <div class="modal fade" id="closeModal" tabindex="-1" aria-labelledby="closeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Cerrar sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">¿Está seguro de que desea cerrar sesión?</p>
                </div>
                <form action="../cerrar-sesion.php" method="post">
                    <div class="modal-footer">
                        <button type="button" class="button-secondary size-10" style="background-color:grey ;" data-bs-dismiss="modal" id="btnCerrarModal">Cancelar</button>
                        <button style="text-align:middle;" value="Cerrar sesión" type="submit" class="button-secondary size-10" data-bs-dismiss="modal" id="btnCerrarModal">Cerrar sesión</button>
                    </div>
            </div>
            </form>
        </div>
    </div>


</body>

</html>