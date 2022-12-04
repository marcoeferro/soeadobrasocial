<?php

    include_once 'conexionExcel.php';

    use Shuchkin\SimpleXLSX;

    include dirname(__FILE__) . '/src/SimpleXLSX.php';

    if (file_exists($_FILES['archivo']['tmp_name'])) {
        try {
            $xlsx = new SimpleXLSX($_FILES['archivo']['tmp_name']);

            // //MySQL
            // $host='localhost';
            // $dbname='soead_excel';
            // $username='root';
            // $pasword ='';
            // $puerto=3307;


            // // Nos conectamos a la BBDD
            // //$conn = new PDO( 'mysql:host=localhost;dbname=soead_excel;port=3307', $username, $pasword);
            // $conn = new PDO( 'mysql:host='.$host.';dbname='.$dbname.';port='.$puerto.'', $username, $pasword);


            //Recorremos los campos del fichero
            foreach ($xlsx->rows() as $fila => $campo) {
                //Evitamos la primera columna, ya que tendrán las cabeceras.

                if ($fila <= 0) {
                    continue;
                }

                $nroAfiliado = $campo[0];
                $nro_asociado = $campo[1];
                //$apellido = $campo[2];
                $nombre = ucwords(strtolower($campo[2])," ");
                $dni = $campo[3];
                $fechaNacimiento = $campo[4];



                $conn->beginTransaction();

                if ($nombre != '') {
                    //INSERTO EL Afiliado
                    $sql = "INSERT INTO afiliados
            (
                nro_afiliado,
                nro_asociado,
                nombre,
                dni,
                fecha_nacimiento
            )
            VALUES (
                '$nroAfiliado',
                '$nro_asociado',
                '$nombre',
                '$dni',
                '$fechaNacimiento'
            )";

                    $stmt = $conn->prepare($sql);

                    $stmt->execute();

                    //$conn->rollBack();

                    $conn->commit();
                } else {
                    $conn->rollBack();
                }
            }
            header("location: ./correcto.php?resultado=1");
        } catch (PDOException $e) {
            header("location: ./correcto.php?resultado=0");
        }
    } else {
        echo "El fichero no existe";
    }

    ?>