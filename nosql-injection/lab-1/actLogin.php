<?php
header('Content-Type: application/json');
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

require '../../vendor/autoload.php';
use MongoDB\Client;

$client = new Client("mongodb://localhost:27017");
$database = $client->selectDatabase('secure_coding');
$collection = $database->selectCollection('users');

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'] ?? null;
$password = $data['password'] ?? null;

if (!is_string($email) || !is_string($password)) {
    echo json_encode(["message" => "Email dan password tidak valid!"]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["message" => "Format email tidak valid!"]);
    exit;
}

$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$password = trim($password);

$user = $collection->findOne(['email' => $email]);

if ($user && isset($user['password']) && password_verify($password, $user['password'])) {
    echo json_encode(["message" => "Login berhasil!"]);
} else {
    echo json_encode(["message" => "Akun Tidak Valid!"]);
}
