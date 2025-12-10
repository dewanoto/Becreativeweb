<?php
require 'mini_mailer/Exception.php';
require 'mini_mailer/SMTP.php';
require 'mini_mailer/PHPMailer.php';

use MiniMailer\PHPMailer;

// Ambil data dari form
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// Inisialisasi
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;

// SMTP Gmail Kamu (HARUS pakai App Password)
$mail->Username = "wdewanoto@gmail.com";
$mail->Password = "APP_PASSWORD_GOOGLE";

// Email pengirim diambil dari input user
$mail->setFrom($email, $name);

// Email penerima adalah email Kamu
$mail->addAddress("wdewanoto@gmail.com");

// Subject form
$mail->Subject = $subject;

// Body email form
$mail->Body =
    "Nama: $name<br>" .
    "Email: $email<br><br>" .
    "Pesan:<br>" . nl2br($message);

// Kirim
if ($mail->send()) {
    echo "Pesan berhasil dikirim.";
} else {
    echo "Pesan gagal dikirim.";
}
