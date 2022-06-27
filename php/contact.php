<?php
include 'PHPMailer/PHPMailerAutoload.php';

//Get Atributes from the form
$name = $_POST['nombre'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$asunto = $_POST['asunto'];
$message = $_POST['mensaje'];

define ("DEMO", false);

//Get Templates Content
$templates_file = file_get_contents('templates/contact_template.php');

//Set the Email From
$email_from = "CF Construcción Modular - Contactos <contacto@cfmodular.cl";

//Replace Object with the values from the form
$swap_var = array(
    "{SITE_ADDR}" => "http://cfmodular.cl",
    "{EMAIL_LOGO}" => "https://cfmodular.cl/prototipo/img/logo/logo__completo.png",
    "{EMAIL_TITLE}" => "Mensaje desde el sitio web",
    "{CUSTOM_URL}" => "http://cfmodular.cl/",
    "{CUSTOM_IMG}" => "",
    "{TO_NAME}" => "CF Construcción Modular",
    "{TO_EMAIL}" => $email,
    "{FROM_NAME}" => $name,
    "{EMAIL}" => $email,
    "{PHONE}" => $phone,
    "{MESSAGE}" => $message,
    "{ASUNTO}" => $asunto
);

// create the email headers to being the email
$email_headers = "From: ".$email_from."\r\nReply-To: ".$email_from."\r\n";
$email_headers .= "MIME-Version: 1.0\r\n";
$email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

// load the email to and subject from the $swap_var
$email_to ="contacto@cfmodular.cl";
$email_subject = $swap_var['{EMAIL_TITLE}']; // you can add time() to get unique subjects for testing: time();

$email_message = $templates_file;

// search and replace for predefined variables, like SITE_ADDR, {NAME}, {lOGO}, {CUSTOM_URL} etc
foreach (array_keys($swap_var) as $key){
    if (strlen($key) > 2 && trim($swap_var[$key]) != '')
        $email_message = str_replace($key, $swap_var[$key], $email_message);
}

$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->Host = "mail.cfmodular.cl";
$mail->Port = 465;
$mail->Username = "noreply@cfmodular.cl";
$mail->Password = "Modular2022$";
$mail->From = "contacto@cfmodular.cl";
$mail->FromName = "CF Contrucción Modular | Contacto";
$mail->Subject = "Contacto Desde la Web";
$mail->Body = $email_message;
$mail->AddAddress("contacto@cfmodular.cl", "Contacto - CF Construcción Modular");
$mail->IsHTML(true);
$mail->AltBody = "Error: Hubo un intento de envio de un mensaje, pero no tuvo exito. Revisé el formulario para comprobar errores.";


// check if the email script is in demo mode, if it is then dont actually send an email
if (DEMO){
    die("<hr /><center>This is a demo of the HTML email to be sent. No email was sent. </center>");
}

if ($mail->send()) {
    echo 1;
}else{
    echo "Error al enviar el mensaje: " . $mail->ErrorInfo;
}