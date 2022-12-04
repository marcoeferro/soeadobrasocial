<?php
session_start();
ob_start();
if (!isset($_SESSION['admin'])) {
    header('location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
    <meta name="generator" content="Hugo 0.88.1" />
    <title>SOEAD - Nuevo centro</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/jumbotron/" />

    <script src="../js/notificaciones.js"></script>

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
    <?php
    include_once('../conexion.php');

    $query1 = "SELECT * FROM ciudades";

    $result1 = mysqli_query($cnx_mysqli, $query1);

    ?>


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

        <!-- ----------------------------Encabezado------------------------- -->
        <nav class="navbar" style="margin-top: 1vh;">
            <div class="container-fluid">
                <a href="./home.php" class="login-header-logo">SOEAD Salud</a>
                <div class="d-flex">
                    <a href="./home.php" class="login-header-button" style="margin-left: 20px;"><button style="padding:8px; background-color:lightslategrey;color:white;">Volver atrás</button></a>
                    <a class="login-header-button" style="margin-left: 20px;"><button style="padding:8px; background-color:lightslategrey;color:white;" name="volver atrás" data-bs-toggle="modal" data-bs-target="#closeModal">Cerrar sesión</button></a>
                </div>
            </div>
        </nav>

        <form id="formAfil" method="POST" action="./acciones/create-centro.php">
            <div class="login-container">
                <h2>Añadir nuevo centro</h2>
                <label for="nombre">Ingrese el nombre</label>
                <input required type="text" id="nombre" name="nombre" placeholder="Nombre del centro de salud" class="mb-4">

                <label for="direccion">Ingrese la dirección</label>
                <input required type="text" id="direccion" name="direccion" placeholder="Dirección del centro de salud" class="mb-4">

                <label for="telefono">Ingrese el teléfono</label>
                <input required type="text" id="telefono" name="telefono" minlength="6" placeholder="Teléfono del centro de salud" class="mb-4">

                <label for="ciudad">Seleccione la ciudad</label>
                <select required type="text" name="ciudad" id="ciudad" placeholder="Ciudad" class="mb" style="display:inline-block">
                    <option value="">Seleccione </option>
                    <?php while ($row2 = mysqli_fetch_array($result1)) :; ?>
                        <option value="<?php echo $row2[0]; ?>"><?php echo $row2[1]; ?></option>
                    <?php endwhile; ?>
                </select>


                <input type="submit" name="iniciar" id="iniciarSesion2" value="Aceptar" class="login-button">

            </div>
        </form>

    </div>
    <div class="footer">
        <a href="https://www.sindicatoaceitero.com.ar" target="_blank" rel="noopener noreferrer">
            <img class="logo" src="./image-2-1-1024x262.png" alt="Kaizen Software Factory - Web Development">
        </a>
        <a href="https://www.osiadsalud.org.ar" target="_blank" rel="noopener noreferrer">
            <img class="logo" src="./logo-osiad-salud.png" alt="Kaizen Software Factory - Web Development">
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
                <form action="../cerrar-sesion.php" method="POST">
                    <div class="modal-footer">
                        <button type="button" class="button-secondary size-10" style="background-color:grey ;" data-bs-dismiss="modal" id="btnCerrarModal">Cancelar</button>
                        <button style="text-align:middle;" value="Cerrar sesión" type="submit" class="button-secondary size-10" data-bs-dismiss="modal" id="btnCerrarModal">Cerrar sesión</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>

</body>

<script src="../assets/bootstrap/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




</html>