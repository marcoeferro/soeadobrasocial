<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    

</head>
<body>

    <?php 
        include_once("Receta.php");
        include_once("ObraSocial.php");
        include_once("User.php");
        include_once("Periodo.php");
        include_once("ResumenPeriodo.php");


        $resumenesPeriodo = ResumenPeriodo::getBy(20134, 1, 4);

        echo json_encode($resumenesPeriodo);
/* 
        $vigente = Periodo::getCurrent(1);
        $periodos = Periodo::getAll(1);
        $vencidos = Periodo::getExpired(1); */

/*         $receta = new receta();

        $receta->recetas = 55;
        $receta->recaudado = 5500;
        $receta->aCargoOS = 2900.50;
        $receta->idFarmacia = 20134;
        $receta->idPeriodo = 4;
        $receta->idObraSocial = 1;

        $receta->save(); */

/*         receta::staticDelete(12) */

    ?>
</body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</html>