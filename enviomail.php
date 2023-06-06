<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require("./assets/phpmailer/class.phpmailer.php");
require("./assets/phpmailer/class.smtp.php");

function obtenerFechaEnLetra($fecha){
    //$dia= conocerDiaSemanaFecha($fecha);
    $num = date("j", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $num.' de '.$mes.' del '.$anno;
    //return $dia.', '.$num.' de '.$mes.' del '.$anno;
}
function conocerDiaSemanaFecha($fecha) {
    $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
    $dia = $dias[date('w', strtotime($fecha))];
    return $dia;
}

$fecha = Date('Y-m-d');
$fechaenletra = obtenerFechaEnLetra($fecha);

$error = "";
$filename = "";
$file =  "";

$mailto="vivimanzanedo@gmail.com"; // a quien se envia 
// $mailto="diagnosticogaya@gmail.com"; // a quien se envia 
$recipient="diagnosticogaya@gmail.com"; //persona a la que se envia
$subject = "Consulta Web."; //asunto
// $mailfrom = $_REQUEST['form_mail'];
// $telefono = $_REQUEST['form_telefono'];
$mailfrom = $_POST['form_mail'];
$telefono = $_POST['form_telefono'];
$message = "Este mensaje fue enviado desde la pagina web.";
$message .= "
        <br>
        <br>
        <p> $fechaenletra</p>
        <br>
        <p>$_POST[form_mensaje]</p>
        ";

$mail = new PHPMailer();

//Server settings
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Port = 587;                                    // TCP port to connect to
// $mail->Host = 'smtp.gmail.com';                  // Specify main and backup SMTP servers
// $mail->Username = 'autenticasmtp@gmail.com';    // SMTP username
// $mail->Password = 'autenticaenvio';                   // SMTP password
$mail->Host = 'c1830658.ferozo.com';                  // Specify main and backup SMTP servers
$mail->Username = 'informatica@defensasde.gob.ar';    // SMTP username
$mail->Password = 'Ministerio2017';                   // SMTP password

$mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

//Recipients
$mail->setFrom('diagnosticogaya@gmail.com', 'Pagina web');
$mail->addAddress($mailto, $recipient);     // Add a recipient

//Content
$mail->isHTML(true);                                  // Set email format to HTML
$mail->CharSet = "utf-8";
$mail->Subject = $subject;
$mail->Body    = $message;

$result = array();

if ($error==""){
    if ($mail->Send()) {
        $result['estado']='ok';
        $result['filename']=$filename;
        $result['mailto']= $mailto;
    } else {
        $result['estado']='nook';
        $result['error']='Error con servidor de mail';
    }
} else {
    $result['estado']='nook';
    $result['error']=$error;
}
echo json_encode($result);

?>

