<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari request body (jika ada)
    $input = json_decode(file_get_contents("php://input"), true);
    
    echo json_encode([
        "message" => "Metode POST berhasil diterima!",
        "data_received" => $input
    ]);
} else {
    echo json_encode([
        "method" => $_SERVER['REQUEST_METHOD'],
        "error" => "Gunakan metode POST."
    ]);
}
?>
