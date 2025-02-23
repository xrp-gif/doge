<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer Autoload (PHPMailer harus di-install dengan Composer)
require 'vendor/autoload.php';

// Fungsi untuk mengirim email
function kirim_email($subject, $body) {
    $mail = new PHPMailer(true);
    try {
        // Aktifkan debugging jika ingin melihat error (set ke 0 untuk menonaktifkan)
        $mail->SMTPDebug = 0;

        // Konfigurasi SMTP Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        
        // Ambil kredensial dari Environment Variables (Vercel)
        $mail->Username = getenv('SMTP_EMAIL'); // Email pengirim
        $mail->Password = getenv('SMTP_PASSWORD'); // Gunakan App Password Gmail
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Pengaturan email
        $mail->setFrom(getenv('SMTP_EMAIL'), 'Nama Anda'); // Nama pengirim
        $mail->addAddress(getenv('SMTP_EMAIL')); // Email tujuan (bisa diubah)

        // Konten email
        $mail->isHTML(false); // Gunakan format teks biasa
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Kirim email
        $mail->send();
        return true; // Email terkirim
    } catch (Exception $e) {
        error_log("Email gagal dikirim: " . $mail->ErrorInfo);
        return false; // Gagal mengirim email
    }
}
?>
