<?php
include "../../../connection.php";
header('Content-Type: application/json');

// Ambil token dari header Authorization
$headers = getallheaders();
$authorization = isset($headers['Authorization']) ? $headers['Authorization'] : '';

if (!preg_match('/Bearer\s(.+)/', $authorization, $matches)) {
    echo json_encode(['result' => 0, 'message' => 'Unauthorized: token not found']);
    exit();
}

$token = $matches[1];

// Gunakan prepared statement untuk menghindari SQL Injection
$stmt = $conn->prepare("
    SELECT users.id, users.username, users.role, access_login.token 
    FROM access_login 
    JOIN users ON users.id = access_login.user_id 
    WHERE access_login.token = ?
");

$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['result' => 0, 'message' => 'Invalid token']);
    exit();
}

$user = $result->fetch_assoc();

// Optional: Anda juga bisa aktifkan session
session_start();
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];

// Validasi role berdasarkan data dari database, bukan dari request
if ($user['role'] === 'member') {
    echo json_encode([
        'result' => 1,
        'message' => 'Welcome to the dashboard',
        'data' => [
            'user_id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ]
    ]);
} else {
    echo json_encode(['result' => 0, 'message' => 'Access denied: insufficient privileges']);
}
?>
