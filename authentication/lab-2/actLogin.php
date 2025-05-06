<?php
require '../../connection.php';

// Pastikan sesi sudah dimulai di connection.php atau di sini
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah key 'phone_number' ada di $_POST
if (isset($_POST['phone_number'])) {
    $phoneNumber = $_POST['phone_number'];
    $host = "http://127.0.0.1:8003";

    // Gunakan prepared statement untuk mencegah SQL Injection
    $query = "SELECT id, phone_number, username FROM users WHERE phone_number = ?";

    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $phoneNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($row) {
            $_SESSION['phone_number'] = $row['phone_number'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header('location: ' . $host . '/authentication/lab-2/otp.php');
            exit;
        } else {
            $_SESSION['error_message'] = "No Handphone tidak ditemukan";
            header('location: ' . $host . '/authentication/lab-2/');
            exit;
        }
    } else {
        // Error preparing the statement
        $_SESSION['error_message'] = "Terjadi kesalahan database.";
        header('location: ' . $host . '/authentication/lab-2/');
        exit;
    }
} else {
    // Jika 'phone_number' tidak ada di $_POST
    $_SESSION['error_message'] = "Data nomor handphone tidak diterima.";
    header('location: ' . $host . '/authentication/lab-2/');
    exit;
}
?>