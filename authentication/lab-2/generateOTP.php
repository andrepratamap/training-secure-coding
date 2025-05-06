<?php
session_start(); // WAJIB ditaruh paling atas

require "../../connection.php";

// Atasi variabel $host yang undefined
$host = "http://127.0.0.1:8003"; // Ganti sesuai kebutuhan lokal/server kamu

if (!isset($_SESSION['phone_number']) || !isset($_SESSION['user_id'])) {
    header('Location: '.$host.'/authentication/lab-2');
    exit();
}

$phoneNumber = $_SESSION['phone_number'];
$userID = $_SESSION['user_id'];

// Generate OTP
$otp = rand(1000, 9999);

// Simpan ke DB (gunakan prepared statement agar lebih aman)
$stmt = $conn->prepare("INSERT INTO otp (otp, user_id) VALUES (?, ?)");
$stmt->bind_param("si", $otp, $userID);
$stmt->execute();

echo "OTP berhasil dikirim (simulasi): $otp"; // Untuk pengujian lokal
?>
