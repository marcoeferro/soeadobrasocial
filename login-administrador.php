<!DOCTYPE html>
<!-- EN ESTE DOCUMENTO IRÍA: 
    1. Login del administrador (cuenta y contraseña)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
    <meta name="generator" content="Hugo 0.88.1" />
    <title>Ingreso administrador</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/jumbotron/" />

    <script src="./js/notificaciones.js"></script>

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

<body style="background-image: linear-gradient(
    135deg,
    var(--osiad-colors-primary-dark),
    var(--osiad-colors-secondary-dark)
  );">

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
        <div class="login-banner-admin"></div>
        <nav class="navbar" style="margin-top: 1vh;">
            <div class="container-fluid">
                <a href="./index.php" class="login-header-logo">SOEAD Salud</a>
                <div class="d-flex">
                <a href="./index.php" class="login-header-button" style="margin-left: 20px;"><button style="padding:8px; background-color:lightslategrey;color:white;">Volver atrás</button></a>
                </div>
            </div>
            
        </nav>
        <form method="POST" action="./entrar-admin.php">
            <div class="login-container">
                <div class="login-card">
                    <div class="login-card-title">
                        <h2>Gestión de SOEAD</h2>
                        <p>Ingrese con sus datos</p>
                    </div>
                    <div class="login-card-body">
                        <label for="admin">Usuario administrador</label>
                        <input required type="text" id="admin" name="admin" placeholder="Usuario" class="mb-4" style="color: black;">
                        <label for="pass">Contraseña</label>
                        <input required type="password" id="pass" name="pass" placeholder="*****" class="mb-4" style="color: black;">
                    </div>
                    <!--input type="submit"-->
                    <!--<button type="button" class="login-button">Iniciar sesión</button>-->
                        <!--a href="/enter-admin/prestadores-lista-administrador.php"><button>Ingresar</button></a-->
                    <input type="submit" name="iniciar" id="iniciarSesion2" value="Ingresar" class="login-button">
                </div>
                <a href="./recuperar-usuario.php">Recuperar usuario</a>
            </div>
        </form>
        
        <!--?php
            $usuario = $_POST['usuario'];
            $contrasenia = $_POST['pass'];
        ?-->
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

<script src="./js/index.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




</html>