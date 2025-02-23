<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo json_encode(["message" => "Metode POST berhasil diterima!"]);
} else {
    echo json_encode(["error" => "Gunakan metode POST."]);
}
?>
