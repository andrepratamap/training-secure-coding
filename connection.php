<?php
$servername = "mysql_db_secure_coding"; // Ganti dengan server database Anda jika perlu
$username = "root"; // Ganti dengan username database Anda
$password = "root"; // Ganti dengan password database Anda
$dbname = "secure_coding"; // Nama database yang dibuat sebelumnya
$port = 3306;
// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname, $port);
$host  = 'http://127.0.0.1:8003';
// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
