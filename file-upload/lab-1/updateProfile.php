<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('Location: ' . $host . '/file-upload/lab-1/');
    die();
}

include '../../connection.php';

$cookieValue = $_COOKIE['accessLogin'];
$queryToken = "SELECT u.username, u.id, p.avatar 
                FROM users u
                JOIN access_login al ON al.user_id = u.id
                JOIN profiles p ON p.user_id = u.id
                WHERE al.token = '$cookieValue'";

$resultQueryToken = $conn->query($queryToken);

if ($resultQueryToken->num_rows == 0) {
    $message = "Data user tidak ditemukan";
    header('Location: ' . $host . '/file-upload/lab-1/index.php?message=' . urlencode($message));
    die();
}

$profile = mysqli_fetch_assoc($resultQueryToken);

// Mulai output buffering
ob_start();

// Update profile
$fileName = $_FILES['avatar']['name'] ?? "";
$directory = '../../assets/gallery/';

if ($fileName) {
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Cek apakah ekstensi file valid
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($fileExtension, $allowedExtensions)) {
        $message = "Hanya file gambar (JPG, PNG, GIF) yang diperbolehkan.";
        header('Location: ' . $host . '/file-upload/lab-1/index.php?message=' . urlencode($message));
        exit();
    }

    // Cek tipe MIME file
    $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileMimeType = mime_content_type($_FILES['avatar']['tmp_name']);
    if (!in_array($fileMimeType, $allowedMimes)) {
        $message = "File yang diupload bukan gambar yang valid.";
        header('Location: ' . $host . '/file-upload/lab-1/index.php?message=' . urlencode($message));
        exit();
    }

    // Nama file yang baru dengan ID unik untuk menghindari konflik
    $newFileName = uniqid('avatar_', true) . '.' . $fileExtension;
    $newFilePath = $directory . $newFileName;
    
    // Pastikan file yang ada adalah file, bukan direktori
    $filePath = $directory . $profile['avatar'];
    if (is_file($filePath)) {
        unlink($filePath);  // Hapus file lama jika ada
    } else {
        $message = "Gagal menghapus file lama karena bukan file yang valid.";
        header('Location: ' . $host . '/file-upload/lab-1/index.php?message=' . urlencode($message));
        exit();
    }

    // Pindahkan file yang diupload ke direktori tujuan
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $newFilePath)) {
        // Jika file berhasil diupload, update avatar
        $avatar = $newFileName;
    } else {
        $message = "File gagal diupload.";
        header('Location: ' . $host . '/file-upload/lab-1/index.php?message=' . urlencode($message));
        exit();
    }
} else {
    // Jika tidak ada file baru, gunakan avatar lama
    $avatar = $profile['avatar'];
}

$idUser = $profile['id'];

$queryUpdateProfile = "UPDATE profiles 
                        SET avatar = '$avatar' 
                        WHERE user_id = '$idUser'";

if ($conn->query($queryUpdateProfile) === FALSE) {
    $message = "Data profile gagal diupdate";
} else {
    $message = "Data profile berhasil diupdate";
}

// Redirect dengan pesan sukses
header('Location: ' . $host . '/file-upload/lab-1/index.php?message=' . urlencode($message));

// Hentikan script setelah pengalihan
exit();

// Akhiri output buffering
ob_end_flush();
