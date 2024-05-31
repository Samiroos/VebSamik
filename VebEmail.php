<body>

<h1>Почта VebAnt</h1>

<form action="email.php" method="get">
Сообщение: <input type="text" name="message">
Email: <input type="text" name="email"><br>
Добавьте файл: <input type="file" name="file" id="file">
<input type="submit">
</form>


</body>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require_once 'phpmailer/PHPMailer.php';

$mail = new PHPMailer();



$recipiant = $_GET["email"];
$message = $_GET["message"];

if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
    $file_name = $_FILES["file"]["name"];
    $file_size = $_FILES["file"]["size"];
    $file_tmp = $_FILES["file"]["tmp_name"];
    $file_type = $_FILES["file"]["type"];

    $mail->AddAttachment($file_tmp, $file_name);
}

$mail->IsSMTP();  
$mail->SMTPAuth   = true; // SMTP аутентификация
$mail->Host       = "smtp.gmail.com"; // SMTP сервер
$mail->Port       = 465; // SMTP Port
$mail->SMTPSecure = 'ssl';
$mail->Username   = "sami"; // SMTP имя пользователя
$mail->Password   = "eqkgbgthachgulqb";        // SMTP пароль

$mail->SetFrom('samira.kharita@yandex.com', 'Mine'); // FROM
$mail->AddReplyTo('samira.kharita@yandex.com', 'Dom'); // Reply TO

$mail->AddAddress($recipiant, 'Dominik Andrzejczuk'); // recipient email

$mail->Subject    = "Первое сообщение"; 
$mail->Body       = $message;

if(!$mail->Send()) {
  echo 'Сообщение не отправлено.';
  echo 'Ошибка отправки: ' . $mail->ErrorInfo;
} else {
  echo 'Сообщение отправлено.';
}
?>