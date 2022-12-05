<?php

$mailAfiliado = $_POST["emailAfil"];

$formater = array("-","/");
$nombreAfiliado = str_replace($formater," ", $_POST["nombrecompleto"]);

$archivo = $_FILES['archivo'];

$body = "Estimado afiliado $nombreAfiliado le informamos 
que ha recibido un reintegro en su obra social";

require '../phpMailer/Exception.php';
require '../phpMailer/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    $mail->setFrom("info@sindicatoaceitero.com.ar", 'Admin');
    $mail->addAddress($mailAfiliado, $nombreAfiliado);
    $mail->Subject = "Reintegro Obra Social";
    $mail->Body    = $body;
    $mail->CharSet =  PHPMailer::CHARSET_UTF8;
    if($archivo['size'] > 0){
      $mail->addAttachment($archivo['tmp_name'], $archivo['name']);
    }
    $mail->send();
    
    header('Location: ../Reintegros.php');
} catch (Exception $e) {
    //$error =  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header('Location: ../Reintegros.php');
}