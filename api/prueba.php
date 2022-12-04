<?php
    include_once("Prestadores/CreatePrestadores.php");

    $Prestadores =  CreatePrestador::createPrestador(22,'donia','tota',234,'Agua-Hedionda',234,'nop',333,999,'puede-ser',1);

    // $PrestadoresTodos = json_encode(GetPrestadores::getAll());

    var_dump($Prestadores);
    
?>