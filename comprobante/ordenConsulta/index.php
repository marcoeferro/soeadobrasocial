<?php
session_start();

	//require('./fpdf/fpdf_alpha.php');
	require('./fpdf/fpdf.php');
	require('../conexiondb.php');


	$id_afiliado=$_SESSION['usuario'];
	$nroasociado=$_GET['numero'];
	$hoy = date("Y-m-d H:i:s");
	$hoyFecha = date("d/m/Y");
	//$factura=5;

		
		//$sql = "SELECT P.ID, OrdenWEB, Fecha, C.Nombre AS NombreCliente, P.LugarEntrega, Total, IDCliente, p.IDEmpleado, status, e.Apellido as ApellidoEmpleado, e.Nombre as NombreEmpleado FROM PedidosWEB P JOIN Clientes C ON P.IdCliente = C.Codigo JOIN Empleados e ON p.IDEmpleado=e.ID WHERE P.ID='$factura' ";
		$sql = "SELECT id_afiliado, nombre, apellido, dni, nro_afiliado, nro_asociado FROM afiliados WHERE nro_afiliado='$id_afiliado' AND nro_asociado= $nroasociado";

		//echo $sql;
    
    	$res=mysqli_query($cnx_mysqli,$sql, MYSQLI_USE_RESULT);
		if($res){
			while ($row = mysqli_fetch_row($res)) {
				$id_afiliado = $row[0];
				$nombre = $row[1];
				$apellido = $row[2];
				$dni = $row[3];
				$nro_afiliado = $row[4];
				$nro_asociado = $row[5];

				


				$GLOBALS["Nombre"] = utf8_decode($nombre);
				$GLOBALS["Apellido"] = utf8_decode($apellido);
				$GLOBALS["DNI"] = $dni;
				$GLOBALS["NroAfiliado"] = $nro_afiliado;
				$GLOBALS["NroAsociado"] = $nro_asociado;
			}
		}

    	//$GLOBALS["IngresosBrutos"]="280440205";
    	//$GLOBALS["InicioActividades"]="01-09-2011";
    	$GLOBALS["FechaHoy"]=$hoyFecha;


    	if ($res) {

    		$cant_filas=mysqli_num_rows($res);

    		//echo $cant_filas;

    		if ($cant_filas == 1){


    			//$GLOBALS["NroComprobante"]=odbc_result($resultado,"OrdenWEB");
    			$GLOBALS["NroComprobante"]="0000000001";


    			$fechaEmision = $hoyFecha;


				$GLOBALS["NombreVendedor"]=$nombre;
				$GLOBALS["ApellidoVendedor"]=$apellido;

    			//TRANSFORMAR FECHA--------------------------------
    			$date = strtotime($fechaEmision);
    			$GLOBALS["FechaEmision"] = date('d-m-Y', $date);
    			//--------------------------------------------------

    			$GLOBALS["NombreCompletoCliente"]=$nombre;

    			$GLOBALS["DomicilioComercial"]="Villa Mercedes";


    			$GLOBALS["Texto"]= "C";

    			//esto no va, es una prueba
    			//$factura = odbc_result($resultado,"NroFac_Anulada");
    			//$GLOBALS["NroFacAnulada"]= "Comp. Origen Nro.: ".$factura."";
    			//$GLOBALS["Texto"]= utf8_decode("NOTA DE CRÉDITO");
    			//---------------------------

    			

    			
    			/*
    			if($GLOBALS["CondicionIva"]=='IVA Responsable Inscripto'){
    				$GLOBALS["Letra"] = 'A';
    			}

    			else{
    				$GLOBALS["Letra"] = 'B';
    			}
    			*/
    			/*
    			else{
    				$GLOBALS["Letra"] = 'B';
    			}
				*/

    			/*
    			if($GLOBALS["CodComprobante"]=='001' || $GLOBALS["CodComprobante"]=='003'){
    				$GLOBALS["Letra"] = 'A';
    			}

    			elseif($GLOBALS["CodComprobante"]=='008' || $GLOBALS["CodComprobante"]=='006'){
    				$GLOBALS["Letra"] = 'B';
    			}

    			elseif($GLOBALS["CodComprobante"]=='333'){
    				$GLOBALS["Letra"] = 'B';
    				$GLOBALS["CodComprobante"]='006';
    			}

    			*/

    			$GLOBALS["Letra"] = 'X';


    			//$GLOBALS["ImporteNetoGravado"]=odbc_result($resultado,"TotalSinIva");

    			//$GLOBALS["qr"]=odbc_result($resultado,"CodigoBarra");

    			//$GLOBALS["Recargo"]=odbc_result($resultado,"Recargo");

    			//$GLOBALS["NombreRecargo"] = 'Recargo';

    			/*if($GLOBALS["Recargo"] == '0,10' OR $GLOBALS["Recargo"] == '0.10' ){

    				$GLOBALS["NombreRecargo"] = 'Ajuste x Cambio';

    			}*/

    			//$GLOBALS["CAE"]=odbc_result($resultado,"CAE");

    			//$GLOBALS["FechaVtoCAE"]=odbc_result($resultado,"Venc_CAE");

    			/*$FechaVtoCAE=odbc_result($resultado,"Venc_CAE");

    			if($FechaVtoCAE!=''){
    				//TRANSFORMAR FECHA--------------------------------
	    			$dateCAE = strtotime($FechaVtoCAE);
	    			$GLOBALS["FechaVtoCAE"] = date('d-m-Y', $dateCAE);
	    			//--------------------------------------------------
    			}
    			else{
    				$GLOBALS["FechaVtoCAE"]=$FechaVtoCAE;
    			}

    			*/

    			//$GLOBALS["MontoIva"]=odbc_result($resultado,"MontoIva");

    			//$GLOBALS["Descuento"]=odbc_result($resultado,"MontoGlobalDesc");

    			$GLOBALS["ImporteTotal"]="Importe Total";

    			$GLOBALS["ID"]=$id_afiliado;

    			//odbc_free_result($resultado);

    			//class PDF extends PDF_ImageAlpha
    			class PDF extends FPDF
				{
				// Cabecera de página
				
				function Header()
				{
				    // Logo
				    $this->Image('../../assets/logo-osiad.png',10,5,40,0,'','', false);
				    //$this->Image('../../assets/img/logo-alfa.png',10,3,40,0,'','', false);
				    $this->SetFont('Arial','',10);

					$this->Cell(40 ,5,'','',0);
					//$this->Cell(60 ,5,utf8_decode('Dirección: aaaaaaaaaaaa 123456'),0,0);
					//$this->Cell(60 ,5,utf8_decode('Dirección: '),'T',0);
					$this->Cell(60 ,5,'','',0);

					$this->SetFont('Arial','B',50);
					//$this->Cell(20 ,35,''.$GLOBALS["Letra"].'',1,0,'C');
					$this->Cell(20 ,30,'',0,0,'C');
					$this->SetFont('Arial','',20);
					$this->Cell(72 ,10,''.$GLOBALS["Texto"].' '.$GLOBALS["NroComprobante"].'',1,0,'C');
					$this->SetFont('Arial','',10);
					//$this->Cell(40 ,5,'Punto de Venta:  ',1,0);
					$this->Cell(0 ,5,'',0,1);

					$this->SetFont('Arial','',12);
					$this->Cell(40 ,5,'',0,0);
					//$this->Cell(30 ,5,'CUIT: 2657333333',0,0);
					$this->Cell(30 ,5,'',0,0);
					$this->Cell(122 ,5,'',0,1);

					$this->SetFont('Arial','',12);
					$this->Cell(40 ,5,'',0,0);
					//$this->Cell(30 ,5,'Telefono: 2657333333',0,0);
					$this->Cell(30 ,5,'',0,0);
					$this->Cell(50 ,5,'',0,0);
					$this->Cell(72 ,5,'',0,1);
					//$this->Cell(122 ,5,'',0,1);

					$this->SetFont('Arial','',12);
					$this->Cell(40 ,5,'',0,0);
					//$this->Cell(50 ,5,'Email: usuario@arab.com.ar',0,0);
					$this->Cell(50 ,5,'',0,0);
					$this->SetFont('Arial','',14);
					$this->Cell(10 ,5,'',0,0);
					//$this->Cell(30 ,5,'Vendedor: '.$GLOBALS["NombreVendedor"].' '.$GLOBALS["ApellidoVendedor"].' ',0,1);
					$this->Cell(30 ,5,'ORDEN DE CONSULTA AMBULATORIA',0,1);

					$this->SetFont('Arial','',12);
					$this->Cell(40 ,5,'',0,0);
					$this->Cell(30 ,5,'',0,0);
					$this->Cell(50 ,5,'',0,0);
					$this->Cell(70 ,5,'',0,1);



					$this->SetFont('Arial','B',12);
					$this->Cell(40 ,5,'',0,0,'C');
					$this->SetFont('Arial','',12);
					$this->Cell(30 ,5,'',0,0);
					$this->SetFont('Arial','',10);
					$this->Cell(30 ,5,'',0,0);
					$this->Cell(20 ,5,'',0,0,'C');
					$this->Cell(70 ,5,'',0,1);

					//$this->Cell(40 ,5,'',0,0);
					//$this->Cell(30 ,5,'',0,0);
					//$this->Cell(50 ,5,'',0,0);
					//$this->Cell(70 ,5,'',0,1);
					$this->Cell(192 ,0,'','B',1);
					$this->Cell(192 ,3,'','LR',1);

					$this->SetFont('Arial','',15);
					$this->Cell(13 ,5,'','L',0);
					$this->Cell(36,5,'OBRA SOCIAL PARA EL PERSONAL DE LA INDUSTRIA ACEITERA,',0,0);
					$this->SetFont('Arial','B',10);
					$this->Cell(143,5,'','R',1);
					$this->SetFont('Arial','',10);

					$this->SetFont('Arial','',15);
					$this->Cell(33 ,5,'','L',0);
					$this->Cell(56 ,5,'DESMOTADORA Y AFINES - O.S.I.A.D SALUD',0,0);
					$this->Cell(103,5,'','R',1);

					$this->SetFont('Arial','',10);
					$this->Cell(15 ,5,'','LB',0);
					$this->Cell(85,5,'','B',0);
					$this->Cell(40,5,'','B',0);
					$this->Cell(52,5,'','RB',1);
					$this->Ln();

					$this->SetFont('Arial','',12);
					$this->Cell(35 ,10,utf8_decode('Lugar de emisión: '),0,0);
					$this->SetFont('Arial','B',14);
					$this->Cell(50,10,utf8_decode('Villa Mercedes'),0,0);
					$this->Cell(50,10,utf8_decode(''),0,0);
					$this->SetFont('Arial','',12);
					$this->Cell(27,10,utf8_decode('Fecha: '),0,0,'R');
					$this->SetFont('Arial','B',14);
					$this->Cell(30,10,utf8_decode($GLOBALS["FechaHoy"]),0,1);

					$this->SetFont('Arial','',12);
					$this->Cell(35 ,10,utf8_decode('Beneficiario Nro: '),0,0);
					$this->SetFont('Arial','B',14);
					$this->Cell(50,10,utf8_decode($GLOBALS['NroAfiliado'].' - '.$GLOBALS['NroAsociado']),0,0);
					$this->SetFont('Arial','',12);
					$this->Cell(50,10,utf8_decode('Edad: '),0,0);
					$this->Cell(27,10,utf8_decode('Sexo: '),0,0,'L');
					$this->Cell(30,10,utf8_decode(''),0,1);

					$this->SetFont('Arial','',12);
					$this->Cell(40 ,10,utf8_decode('Apellido y Nombre: '),0,0);
					$this->SetFont('Arial','B',14);
					$this->Cell(50,10,$GLOBALS['Apellido'].' '.$GLOBALS['Nombre'],0,0);
					$this->Cell(50,10,utf8_decode(''),0,0);
					$this->Cell(22,10,utf8_decode(''),0,0,'L');
					$this->Cell(30,10,utf8_decode(''),0,1);

					$this->SetFont('Arial','',12);
					$this->Cell(40 ,10,utf8_decode('Domicilio: '),0,0);
					$this->SetFont('Arial','B',14);
					$this->Cell(50,10,utf8_decode(''),0,0);
					$this->Cell(50,10,utf8_decode(''),0,0);
					$this->Cell(22,10,utf8_decode(''),0,0,'L');
					$this->Cell(30,10,utf8_decode(''),0,1);

					$this->SetFont('Arial','',12);
					$this->Cell(40 ,10,utf8_decode('Fecha Prestación: '),0,0);
					$this->SetFont('Arial','B',14);
					$this->Cell(50,10,utf8_decode(''),0,0);
					$this->Cell(50,10,utf8_decode(''),0,0);
					$this->SetFont('Arial','',12);
					$this->Cell(22,10,utf8_decode('Código N.N: '),0,0,'L');
					$this->Cell(30,10,utf8_decode(''),0,1);

					$this->SetFont('Arial','',12);
					$this->Cell(40 ,10,utf8_decode('Establecimiento: '),0,0);
					$this->SetFont('Arial','B',14);
					$this->Cell(50,10,utf8_decode(''),0,0);
					$this->Cell(50,10,utf8_decode(''),0,0);
					$this->SetFont('Arial','',12);
					$this->Cell(22,10,utf8_decode(''),0,0,'L');
					$this->Cell(30,10,utf8_decode(''),0,1);

					$this->SetFont('Arial','',12);
					$this->Cell(40 ,10,utf8_decode('Nro. de Orden de Internación: '),0,0);
					$this->SetFont('Arial','B',14);
					$this->Cell(50,10,utf8_decode(''),0,0);
					$this->Cell(50,10,utf8_decode(''),0,0);
					$this->SetFont('Arial','',12);
					$this->Cell(22,10,utf8_decode(''),0,0,'L');
					$this->Cell(30,10,utf8_decode(''),0,1);


					$this->SetFont('Arial','',12);
					$this->Cell(64 ,10,utf8_decode('Firma Beneficiario'),'R',0,'C');
					$this->Cell(64,10,utf8_decode('Motivo o Diagnostico'),0,0,'C');
					$this->Cell(64,10,utf8_decode('Firma y Sello Profesional'),'L',1,'C');


					$this->Cell(64 ,60,utf8_decode(''),'R',0,'C');
					$this->Cell(64,60,utf8_decode(''),0,0,'C');
					$this->Cell(64,60,utf8_decode(''),'L',1,'C');
				}
				

				// Pie de página
				function Footer()
				{
				    // Posición: a 1,5 cm del final
				    //$this->SetY(-15);
				    
				    $this->SetY(-10);
				    // Arial italic 8
				    $this->SetFont('Arial','I',8);
				    // Número de página
				    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
				}


				// Cargar los datos
				function LoadData($file)
				{
					// Leer las líneas del fichero
					$lines = file($file);
					$data = array();
					foreach($lines as $line)
						$data[] = explode(';',trim($line));
					//print_r($data);
					return $data;
				}

				// Tabla simple
				function BasicTable($header, $data)
				{
					// Cabecera
					foreach($header as $col)
						$this->Cell(6,6,$col,1);
					$this->Ln();
					// Datos
					foreach($data as $row)
					{
						foreach($row as $col)
							$this->Cell(5,5,$col,1);
						$this->Ln();
					}
				}

				function ImprovedTable($header, $data)
				{
				    // Anchuras de las columnas $pdf->SetFont('Arial','B',14);
				    //$w = array(8, 20, 77, 15, 18, 14, 20, 22);  //el total tiene que ser 192
				    $w = array(8, 35, 92, 15, 20, 24);  //el total tiene que ser 192
				    $this->SetFont('Arial','B',10);
				    // Cabeceras
				    for($i=0;$i<count($header);$i++){
				        $this->Cell($w[$i],7,$header[$i],1,0,'C');
				    }
				    $this->Ln();
				    $this->SetFont('Arial','',10);
				    // Datos
				    foreach($data as $row)
				    {
				        $this->Cell($w[0],6,$row[0],1,0,'C');
				        $this->Cell($w[1],6,$row[1],1,0,'C');
				        $this->Cell($w[2],6,$row[2],1,0,'C');
				        $this->Cell($w[3],6,$row[3],1,0,'R');
				        $this->Cell($w[4],6,$row[4],1,0,'R');
				        $this->Cell($w[5],6,$row[5],1,0,'R');
				        //$this->Cell($w[6],6,$row[6],1,0,'R');
				        //$this->Cell($w[7],6,$row[7],1,0,'R');
				        $this->Ln();
				    }
					for($i=0;$i<4;$i++){
				        $this->Cell($w[0],6,' ',1,0,'C');
				        $this->Cell($w[1],6,' ',1,0,'C');
				        $this->Cell($w[2],6,' ',1,0,'C');
				        $this->Cell($w[3],6,' ',1,0,'C');
				        $this->Cell($w[4],6,' ',1,0,'C');
				        $this->Cell($w[5],6,' ',1,0,'C');
						$this->Ln();
				    }

				    // Línea de cierre
				    $this->Cell(array_sum($w),0,'','T');
				}


				}

				$pdf = new PDF('P','mm','A4');
				$pdf->AliasNbPages();
				$pdf->AddPage();				
    		
    		}
    		/* liberar el conjunto de resultados */
    		

    	}

    	// //$pdf->Ln();
    	// //det_ventas
    	// //$consulta_detalle= "SELECT ID, OrdenWeb,Fecha, IdCliente, LugarEntrega, Total, IDEmpleado FROM PedidosWEB WHERE ID = '$codigoOrden'";
    	// $consulta_detalle= "SELECT IDOrdenWEB, IDMaterial, m.CodigoBarra, m.Nombre AS NombreMAterial, p.IDMarca, p.IDUnidad, p.Precio, p.QtyPedida, p.Subtotal, Descuento FROM PedidosWEB_det p JOIN Materiales m ON IDMaterial=m.Codigo WHERE IDOrdenWEB = '$factura' ";

    	// //echo "$consulta_detalle";
    	// $header = array(utf8_decode('Item'), utf8_decode('Código'), utf8_decode('Producto'), utf8_decode('Cant'), utf8_decode('Precio U'), utf8_decode('SubTotal') );

    	// //$result_d = $conex->query($consulta_detalle);

    	// $result_d = odbc_exec( $conn, $consulta_detalle );

    	// if ($result_d) {

    	// 	$contador_detalle = 0;

		//     /* obtener un array asociativo */
		//     while ($fila = odbc_fetch_object($result_d)) {

		//         //$codigo=$fila->IDOrdenWEB;
		//         $codigo=$fila->IDMaterial;
		//         $codigoBarra=$fila->CodigoBarra;
		//         //$producto=$fila->IDMaterial;
		//         $producto=$fila->NombreMAterial;
		// 		$unidad=$fila->IDUnidad;
		//         $cantidad=$fila->QtyPedida;
		//         $preciou=$fila->Precio;
		//         $subtotal=$fila->Subtotal;

		// 		$data[$contador_detalle] = array(''.($contador_detalle+1).'', utf8_decode($codigoBarra), utf8_decode($producto.' - '.$unidad), utf8_decode($cantidad), utf8_decode($preciou), utf8_decode($subtotal));

    	// 		$contador_detalle = $contador_detalle + 1;

		//     }


		//     /* liberar el conjunto de resultados */
		//     //odbc_free_result($result_d);
		// }

		// $pdf->ImprovedTable($header,$data);
		$pdf->Ln();

		$pagina = $pdf->PageNo();

	    //$ubicacion_qr=($contador_detalle*6)+75;

	    // if($contador_detalle>=(35*($pagina-1))){
	    // 	$ubicacion_qr=(($contador_detalle-(35*($pagina-1)))*6)+75;

	    // 	if($ubicacion_qr>257){
	    // 		$ubicacion_qr= 65;
	    // 	}
	    // }
	    // else{
	    // 	$ubicacion_qr=($contador_detalle*6)+75;
	    // }


		/*
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(124 ,6,'',0,0);
		$pdf->Cell(48 ,6,'Descuento ($)',0,0,'R');
		$pdf->Cell(22 ,6,''.$GLOBALS["Descuento"].'',1,1,'R');

		
		$pdf->Cell(124 ,6,'CAE: '.$GLOBALS["CAE"].' ',0,0);
		$pdf->Cell(48 ,6,''.$GLOBALS["NombreRecargo"].' ($)',0,0,'R');
		$pdf->Cell(22 ,6,''.$GLOBALS["Recargo"].'',1,1,'R');

		
		$pdf->Cell(124 ,6,'Fecha de vto CAE: '.$GLOBALS["FechaVtoCAE"].' ',0,0);
		$pdf->Cell(48 ,6,'Importe Neto Gravado ($)',0,0,'R');
		$pdf->Cell(22 ,6,''.$GLOBALS["ImporteNetoGravado"].'',1,1,'R');

		
		$pdf->Cell(124 ,6,'',0,0);
		$pdf->Cell(48 ,6,'IVA (21) % ($)',0,0,'R');
		$pdf->Cell(22 ,6,''.$GLOBALS["MontoIva"].'',1,1,'R');

		//$pdf->Image('https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl='.$valorqr.'&choe=UTF-8&.png', 0,190,15);

		$pdf->Image('https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl='.$GLOBALS["qr"].'&choe=UTF-8&.png', 70,$ubicacion_qr,30);

		*/
		
		// $pdf->Cell(124 ,6,'',0,0);
		// $pdf->SetFont('Arial','B',10);
		// $pdf->Cell(46 ,6,'Importe Total ($)',0,0,'R');
		// $pdf->Cell(24 ,6,''.$GLOBALS["ImporteTotal"].'',1,1,'R');
		// $pdf->SetFont('Arial','',10);


		// //$w = array(8, 20, 86, 10, 20, 25, 25);
		// $pdf->Ln(15);
		// $pdf->SetFont('Arial','',10);
		// $pdf->Cell(190 ,6,utf8_decode('Valoración Vendedor: '),0,1);
		// $header2 = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10');
		// $data2=array();
		// $pdf->BasicTable($header2,$data2);
		// $pdf->SetFont('Arial','',7);
		// $pdf->Cell(190 ,6,utf8_decode('Marcar con un círculo'),0,1);

		// $pdf->SetFont('Arial','',10);
		// $pdf->Cell(190 ,6,utf8_decode('Valoración Delivery: '),0,1);
		// $header2 = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10');
		// $data2=array();
		// $pdf->BasicTable($header2,$data2);
		// $pdf->SetFont('Arial','',7);
		// $pdf->Cell(190 ,6,utf8_decode('Marcar con un círculo'),0,1);

		
		
	//odbc_close($conn);

	$pdf->Output('I','Orden-'.$GLOBALS["NroComprobante"].'.pdf',true);
	//$pdf->Output();


?>