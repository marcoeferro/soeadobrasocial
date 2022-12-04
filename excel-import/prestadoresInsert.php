<?php

include_once 'conexionExcel.php';

use Shuchkin\SimpleXLSX;

include dirname(__FILE__).'/src/SimpleXLSX.php';

if(file_exists($_FILES['archivo']['tmp_name'])){
    $centro=$_POST['centros'];
    $sql_centros="SELECT id_centro FROM centros WHERE nombre='$centro'";
    $resultado=$conn->query($sql_centros);
    $idCentro=$resultado->fetchColumn();
try {
    $xlsx = new SimpleXLSX($_FILES['archivo']['tmp_name']);

    // //MySQL
    // $host='localhost';
    // $dbname='soead_excel';
    // $username='root';
    // $pasword ='';
    // $puerto=1433;


    // // Nos conectamos a la BBDD
    // $conn = new PDO( 'mysql:host=localhost;dbname=soead_excel;port=3307', $username, $pasword);


    //Recorremos los campos del fichero
    foreach ($xlsx->rows() as $fila => $campo) {
        //Evitamos la primera columna, ya que tendrán las cabeceras.

        if ($fila<=0) {
            continue;
        }

        //$Apellido = $campo[0];
        //$Nombre = $campo[0];
        $Nombre = ucwords(strtolower($campo[0])," ");
        $Especialidades = ucfirst(strtolower($campo[1]));

        $Especialidad = explode(",", $Especialidades);
        //var_dump($Especialidad);



        $conn->beginTransaction();

        if ($Nombre!='') {
            //INSERTO EL PRESTADOR
            $sql = "INSERT INTO prestadores
            (
            nombre,
            id_centro
            )
            VALUES (
                '$Nombre',
                $idCentro
            )";

            $stmt = $conn->prepare($sql);

            //var_dump($sql);

            $stmt->execute();

            $idPrestador = $conn->lastInsertId();

            //echo $idPrestador."-->IdPrestador<br>";

            //LEO LAS ESPECIALIDADES
            foreach ($Especialidad as $especialidad) {
                //var_dump($especialidad);

                //verificar si existe la especialidad
                $sql = "SELECT * FROM especialidades WHERE nombre = '$especialidad'";
                //var_dump($sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $especialidadExiste = $stmt->fetch(PDO::FETCH_ASSOC);

                //echo $sql."<br>";

                // var_dump($especialidadExiste);
                // echo "<br>gggg<br>";

                //VERIFICO SI EXISTEN LAS ESPECIALIDADES
                if ($especialidadExiste) {
                    $idEspecialidad = $especialidadExiste['id_especialidad'];
                } else {
                    //Insertar especialidad

                    $sqlEspecialidades = "INSERT INTO especialidades
                    ( nombre)
                    VALUES (
                        '$especialidad'
                    )";

                    //var_dump($sqlEspecialidades);

                    $stmtEspecialidades = $conn->prepare($sqlEspecialidades);

                    $stmtEspecialidades->execute();

                    //Traigo el id de la especialidad insertada

                    $sqlIdEspecialidad = "SELECT id_especialidad FROM especialidades WHERE nombre = '$especialidad' ORDER BY id_especialidad DESC LIMIT 1 ";

                    $stmtIdEspecialidad = $conn->query($sqlIdEspecialidad);

                    $rows = $stmtIdEspecialidad->fetchAll();

                    $idEspecialidad="";

                    foreach ($rows as $row) {
                        $idEspecialidad = $row['id_especialidad'];
                    }
                }

                //echo $idEspecialidad."-->IdEspecialidad<br>";

                //INSERTO LA RELACION ENTRE PRESTADOR Y ESPECIALIDAD
                $sqlPrestadorEspecialidad = "INSERT INTO prestadores_especialidad (IdPrestador, IdEspecialidad) VALUES ($idPrestador, $idEspecialidad)";
                //var_dump($sqlPrestadorEspecialidad);
                $stmtPrestadorEspecialidad = $conn->prepare($sqlPrestadorEspecialidad);

                $stmtPrestadorEspecialidad->execute();

                //echo $sqlPrestadorEspecialidad."<br>";
            }


            //$conn->rollBack();

            $conn->commit();
        } else {
            $conn->rollBack();
        }
    }
    header("location: ./correcto-prestadores.php?resultado=1");
}catch(PDOException $e) {
    header("location: ./correcto-prestadores.php?resultado=0");
}
}else{
    echo "El fichero no existe";
}
    
?>