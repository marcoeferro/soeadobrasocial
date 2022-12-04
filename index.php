<?php
    session_start();
    ob_start();
    if (isset($_SESSION['usuario'])) {
        header('location: ./enter-afil/home.php');
    }
    if (isset($_SESSION['admin'])) {
        header('location: ./enter-admin/home.php');
    }
?>
<!DOCTYPE html>
<!-- EN ESTE DOCUMENTO IRÍA:  (EVERYONE)
    1. Ingreso para administrador
    2. Ingreso para afiliado
    3. (principal) Lista de prestadores
        3.1 Búsq por nombre
        3.2 Búsqueda por especialidad
        3.3 Búsqueda por centro
-->

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
    <meta name="generator" content="Hugo 0.88.1" />
    <title>SOEAD - Obra Social</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/jumbotron/" />

    <script src="./js/index.js"></script>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="./css/styles.css" rel="stylesheet" />
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        $(window).load(function() {
            $('#page-loader').fadeOut(500);
        });
    </script>

</head>

<body>

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
    

    <div class="body-main">
        <div class="index-banner"></div> 
        <nav class="navbar" style="margin-top: 1vh;">
            <div class="container-fluid">
                <a href="./index.php" class="login-header-logo">SOEAD Salud</a>
                <div class="d-flex">
                    <a href="./login-afiliado.php" class="login-header-button" style="margin-left: 20px;display:none;" disabled ><button>Ingreso afiliados</button></a>
                    <a href="./login-administrador.php" class="login-header-button" style="margin-left: 20px;"><button>Gestión</button></a>
                </div>
            </div>
        </nav>
        <!-- FORMULARIO-->
        <div class="table-container">
            <h3>ESPECIALISTAS OFRECIDOS POR OSIAD SALUD</h3>
            <!-- BÚSQUEDA -->
            <table id="tablaPrestadores">
                <thead>
                    <tr>
                    <th scope="col">Especialidad</th>
                    <th scope="col">Apellido y nombre</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Centro de salud</th>
                    <th scope="col">Contacto</th>
                    </tr>
                </thead>
                <tbody style="padding:5px ;width:100%"> 
                
                </tbody>
            </table>
        </div>

    </div>
    <div class="footer">
        <a href="https://www.sindicatoaceitero.com.ar" target="_blank" rel="noopener noreferrer">
            <img class="logo" src="./assets/image-2-1-1024x262.png" alt="Kaizen Software Factory - Web Development">
        </a>
        <a href="https://www.osiadsalud.org.ar" target="_blank" rel="noopener noreferrer">
            <img class="logo" src="./assets/logo-osiad-salud.png" alt="Kaizen Software Factory - Web Development">
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

</body>

<script src="./assets/bootstrap/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!-- <script src="js/index.js"></script> -->

<!-- Datatable -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/scroller/2.0.7/js/dataTables.scroller.min.js"></script>
    <script src="https://nightly.datatables.net/select/js/dataTables.select.js?_=9a6592f8d74f8f520ff7b22342fa1183"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

    <script src="./dtprestadores.js"></script>

</html>