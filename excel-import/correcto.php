<?php
    session_start();
    ob_start();
    if (!isset($_SESSION['admin'])) {
        header('location: ../index.php');
        }
        if($_GET['resultado']==1){
            $resultado=1;
        }else{
            $resultado=0;
        }
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta http-equiv='cache-control' content='no-cache'>
  <meta http-equiv='expires' content='0'>
  <meta http-equiv='pragma' content='no-cache'>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <?php header('Content-Type: text/html; charset=utf-8'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
    <meta name="generator" content="Hugo 0.88.1" />

  <title>Importar afiliados</title>
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
                    <a href="./afiliados.php" class="login-header-button" style="margin-left: 20px;"><button style="padding:8px; background-color:lightslategrey;color:white;">Volver atr??s</button></a>
                    <a class="login-header-button" style="margin-left: 20px;"><button style="padding:8px; background-color:lightslategrey;color:white;" name="volver atr??s" data-bs-toggle="modal" data-bs-target="#closeModal">Cerrar sesi??n</button></a>
                </div>
            </div>
        </nav>

<form method="post" action="afiliadosInsert.php" enctype="multipart/form-data" class="form-group">
<div class="login-container" style="width: 45%;">
      <div class="">      
          <?php 
          if($resultado==1){
            echo '<div style="vertical-align: middle;text-align: center;">
                    <p>Se a??adieron los afiliados correctamente</p> 
                    <a href="../enter-admin/home.php" class="btn btn-success">
                        Volver al inicio
                    </a>
                </div>' ;
            } else {
                echo '<div style="vertical-align: middle;text-align: center;">
                    <p>Los datos en el archivo son incorrectos</p>
                    <a href="./afiliados.php" class="btn btn-success" style="margin-left: 20px;">
                        Volver a cargar
                    </a>
                </div>';
            }
            
            ?>
      </div>
    
  </div>
</form>


  <div class="footer">
        <a href="https://www.sindicatoaceitero.com.ar" target="_blank" rel="noopener noreferrer">
            <img class="logo" src="../enter-admin/image-2-1-1024x262.png" alt="Kaizen Software Factory - Web Development">
        </a>
        <a href="https://www.osiadsalud.org.ar" target="_blank" rel="noopener noreferrer">
            <img class="logo" src="../enter-admin/logo-osiad-salud.png" alt="Kaizen Software Factory - Web Development">
        </a>
        <p class="copy-right">Copyright &copy; <script>document.write(new Date().getFullYear())</script> Kaizen All Rights Reserved</p>
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
            <h5 class="modal-title" id="">Cerrar sesi??n</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <p class="mb-0">??Est?? seguro de que desea cerrar sesi??n?</p>
        </div>
        <form action="../cerrar-sesion.php" method="post">
            <div class="modal-footer">
                <button type="button" class="button-secondary size-10" style="background-color:grey ;" data-bs-dismiss="modal" id="btnCerrarModal">Cancelar</button>
                <button  style="text-align:middle;" value="Cerrar sesi??n" type="submit" class="button-secondary size-10" data-bs-dismiss="modal" id="btnCerrarModal">Cerrar sesi??n</button>
            </div>
            </div>
        </form>
        </div>
    </div>

</body>

<script src="../assets/bootstrap/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</html>