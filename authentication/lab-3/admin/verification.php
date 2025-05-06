<?php
include "../../../connection.php";
header('Content-Type: application/json');

// Ambil token dari header Authorization
$headers = getallheaders();
$authorization = isset($headers['Authorization']) ? $headers['Authorization'] : '';

if (!preg_match('/Bearer (.+)/', $authorization, $matches)) {
    echo json_encode(['result' => 0, 'message' => 'No token provided']);
    exit();
}

$token = $matches[1];

// Cek token di database dan ambil user + role
$stmt = $conn->prepare("
    SELECT users.id, users.username, users.role 
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

// ✅ Cek role user di server (bukan dari body)
if ($user['role'] !== 'admin') {
    echo json_encode(['result' => 0, 'message' => 'Unauthorized']);
    exit();
}

echo json_encode([
    'result' => 1,
    'message' => 'Welcome, Admin',
    'username' => $user['username'],
]);
