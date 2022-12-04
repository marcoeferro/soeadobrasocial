<?php

$mailAfiliado = $_POST["emailAfil"];
$nombreAfiliado = $_POST["nombrecompleto"];
$archivo = $_POST["archivo"];


// the message
$msg = `Estimado afiliado ${nombreAfiliado} se ha habilitado un `;

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

//cabecera
$cabecera = 'From: info@sindicatoaceitero.com.ar' . "\r\n" .'Reply-To: info@sindicatoaceitero.com.ar';

// send email
mail($mailAfiliado,"Reintegros",$msg,$cabecera);

?>