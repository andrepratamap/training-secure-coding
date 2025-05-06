<?php
session_start();
require '../../connection.php';

// Proteksi brute force (sederhana)
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if ($_SESSION['login_attempts'] >= 5) {
    $_SESSION['error_message'] = "Terlalu banyak percobaan login. Coba lagi nanti.";
    header('location: '.$host.'/authentication/lab-1/');
    exit;
}

// Validasi input
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

// Cek apakah reCAPTCHA diisi
if (empty($recaptcha_response)) {
    $_SESSION['error_message'] = "Silakan verifikasi CAPTCHA.";
    header('location: '.$host.'/authentication/lab-1/');
    exit;
}

// Verifikasi CAPTCHA dengan Google
$secret_key = '6LfEOC8rAAAAAIPO8DJDa7UUqk3HChDwXcv9h2yx';
$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
$response = file_get_contents($recaptcha_url.'?secret='.$secret_key.'&response='.$recaptcha_response);
$response_keys = json_decode($response, true);

// Jika CAPTCHA gagal
if(intval($response_keys['success']) !== 1) {
    $_SESSION['error_message'] = "Verifikasi CAPTCHA gagal. Coba lagi.";
    header('location: '.$host.'/authentication/lab-1/');
    exit;
}

// Validasi email dan password
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
    $_SESSION['error_message'] = "Format email atau password salah.";
    header('location: '.$host.'/authentication/lab-1/');
    exit;
}

// Query aman pakai prepared statement
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['username'] = $user['username'];
    $_SESSION['login_attempts'] = 0; // reset
    header('location: '.$host.'/authentication/lab-1/profile.php');
    exit;
} else {
    $_SESSION['login_attempts']++;
    $_SESSION['error_message'] = "Email dan Password tidak cocok";
    header('location: '.$host.'/authentication/lab-1/');
    exit;
}
