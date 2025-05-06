<?php
include "../../../connection.php";
session_start();

// Proteksi akses: hanya untuk admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');

    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Coding | Authentication</title>
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../../../assets/css/style.css" type="text/css">
    <style>
        button {
            background-color: #006699 !important;
            color: white !important;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <aside class="sidebar">
        <p>Halaman Dashboard Admin</p>
    </aside>

    <div class="main-content">
        <div class="filter">
            <a href="<?php echo $host; ?>/authentication/"><button type="button" class="btn btn-outline-primary">Back</button></a>
        </div>

        <div class="login-container">
            Selamat datang, <strong><?php echo $_SESSION['username']; ?></strong>! Anda berada di area admin.
        </div>
    </div>
</div>

</body>
</html>
