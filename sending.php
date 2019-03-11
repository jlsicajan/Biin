<?php
// using SendGrid's PHP Library
// https://github.com/sendgrid/sendgrid-php

require("sendgrid-php/sendgrid-php.php");

$emails_file = 'emails.txt';

$file = fopen($emails_file, 'a') or die("Can't create file");

$new_email = $_POST['new_email'];

fwrite($file, $new_email);
fwrite($file, "\n");

fclose($emails_file);

$email = new \SendGrid\Mail\Mail();
$email->setFrom("cuentanos@biin.mx", "Biin.");
$email->setSubject("Biin Transporte Publico");
$email->addTo($new_email, '');
$email->addContent("text/plain", "Paga el transporte público con tu celular - Descarga nuestra aplicación, acerca tu celular al lector y olvidate de las monedas.");
$email->addContent("text/html", '<h1 class="w3-jumbo"><font color="black"><b>BiiN</b></font><img src="http://www.biin.mx/assets/pics/biin_logo.png" alt="Biin" style="width:100px;height:100px;"></h1><h2><font color="red">¡Muchas gracias por suscribirte a nuestra newsletter! A partir de ahora recibirás en tu correo novedades de Biin</font></h2>');
$sendgrid = new \SendGrid('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');

try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
