<?php
    session_start();
    ob_start();
    //var_dump($_SESSION['admin']);
    if (!isset($_SESSION['admin'])) {
        header('location: ./../index.php');
        }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php header('Content-Type: text/html; charset=utf-8'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
    <meta name="generator" content="Hugo 0.88.1" />
    <title>SOEAD - Autorizaciones</title>

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

    <div class="body-main">
        <nav class="navbar" style="margin-top: 1vh;">
            <div class="container-fluid">
                <a href="" class="login-header-logo">SOEAD Salud</a>
                <div class="d-flex"> <!-- Mejorar estilos: tiene que estar más bonito-->
                    <li class="nav-item dropdown"> 
                        <a class="nav-link dropdown-toggle" style="border-radius: 20px;color: white; font-size: 16px; border: solid 1px white; cursor: pointer;" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Añadir
                        </a>
                        <ul style="border-radius:20px ;" class="dropdown-menu" >
                            <a href="./nuevo-admin.php" class="login-header-button" ><button>Administrador</button> </a>
                            <a href="./nuevo-afiliado.php" class="login-header-button"><button>Afiliado</button></a>
                            <a href="./nueva-autorizacion.php" class="login-header-button"><button>Autorización</button></a>
                            <a href="./nuevo-centro.php" class="login-header-button"><button>Centro</button></a>
                            <a href="./nuevoprestador.php" class="login-header-button"><button>Prestador</button></a>
                            <a href="./Reintegros.php" class="login-header-button"><button>Reintegros</button></a>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" style="margin-left: 20px;border-radius: 20px;color: white; font-size: 16px; border: solid 1px white; cursor: pointer;" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Importar
                        </a>
                        <ul style="border-radius:20px ;" class="dropdown-menu" >
                            <a href="../excel-import/afiliados.php" class="login-header-button" ><button>Afiliados</button></a>
                            <a href="../excel-import/prestadores.php" class="login-header-button" ><button>Prestadores</button></a>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" style="margin-left: 20px;border-radius: 20px;color: white; font-size: 16px; border: solid 1px white; cursor: pointer;" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ver
                        </a>
                        <ul style="border-radius:20px ;" class="dropdown-menu" >
                            <a href="./afiliados-lista.php" class="login-header-button" ><button>Afiliados</button></a>
                            <a href="./prestadores-lista-administrador.php" class="login-header-button" ><button>Prestadores</button></a>
                            <a href="./ordenes.php" class="login-header-button" ><button>Órdenes</button></a>
                        </ul>
                    </li>
                    
                    <div class="d-flex">
                    <a class="login-header-button" style="margin-left: 20px;"><button style="padding:8px; background-color:lightslategrey;color:white;" name="volver atrás" data-bs-toggle="modal" data-bs-target="#closeModal">Cerrar sesión</button></a>
                </div>
                </div>
            </div>
        </nav>
        <!-- FORMULARIO-->
        <div class="table-container">
        <div style="display:inline-flex;justify-content:space-between">
            <h3>LISTADO DE AUTORIZACIONES</h3>
            <a href="./nueva-autorizacion.php" class="login-header-button"><button style="border: 1px solid grey;">+ Añadir autorización</button></a>
        </div> <br>
            <table id="tablaAutorizaciones">
                <thead>
                    <tr>
                    <th scope="col">Descripción</th>
                    <th scope="col">Afiliado</th>
                    <th scope="col">Fecha de Emisión</th>
                    <th scope="col">Prestador</th>
                    <th scope="col">Estado</th>
                    </tr>
                </thead>
            <tbody style="padding:5px ;width:100%"> 
            </tbody>
        </table>
        </div>

    </div>
    <div class="footer">
        <a href="https://www.sindicatoaceitero.com.ar" target="_blank" rel="noopener noreferrer">
            <img class="logo" src="./image-2-1-1024x262.png" alt="Kaizen Software Factory - Web Development">
        </a>
        <a href="https://www.osiadsalud.org.ar" target="_blank" rel="noopener noreferrer">
            <img class="logo" src="./logo-osiad-salud.png" alt="Kaizen Software Factory - Web Development">
        </a>
        <p class="copy-right">Copyright &copy; <script>document.write(new Date().getFullYear())</script> Kaizen All Rights Reserved</p>
        <ul>
            <li>Inicio</li>
            <li id="ayuda-label" style="cursor: pointer;">Ayuda</li>
        </ul>
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
                        <button  style="text-align:middle;" value="Cerrar sesión" type="submit" class="button-secondary size-10" data-bs-dismiss="modal" id="btnCerrarModal">Cerrar sesión</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="aprobarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aprobar una autorización</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Quiere aprobar las autorización?
            </div>
            <div class="modal-footer">
                <input type="hidden" id='eliminarid' name='eliminarid'>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" onclick=aprobar()>Aceptar</button>
            </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="denegarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Denegar una autorización</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Quiere denegar las autorización?
            </div>
            <div class="modal-footer">
                <input type="hidden" id='eliminarid' name='eliminarid'>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick=denegar()>Aceptar</button>
            </div>
            </div>
        </div>
    </div>

</body>

<script src="../assets/bootstrap/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script src="../js/index.js"></script>
<!-- Datatable -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/scroller/2.0.7/js/dataTables.scroller.min.js"></script>
    <script src="https://nightly.datatables.net/select/js/dataTables.select.js?_=9a6592f8d74f8f520ff7b22342fa1183"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

    <script src="./data/dataTableAutorizaciones.js"></script>

    <script>
        function aprobarModal(id){
            $('#eliminarid').val(id);
            $('#aprobarModal').modal('show');
        }
        function denegarModal(id){
            $('#eliminarid').val(id);
            $('#denegarModal').modal('show');
        }
        function denegar(){
            let id = $('#eliminarid').val();
            $('#form_eliminar_denegar_'+id).submit();
        }
        function aprobar(){
            let id = $('#eliminarid').val();
            $('#form_eliminar_aprobar_'+id).submit()
        }
    </script>

</html>