<?php
include '../../connection.php';

$accessLogin = 'accessLogin';
$isLogin = false;
$username = null;

if (isset($_COOKIE[$accessLogin])) {
    $cookieValue = $_COOKIE[$accessLogin];

    $stmt = $conn->prepare("SELECT u.username 
                            FROM users u 
                            JOIN access_login al ON al.user_id = u.id 
                            WHERE al.token = ?");
    $stmt->bind_param("s", $cookieValue);
    $stmt->execute();
    $resultQueryToken = $stmt->get_result();

    if ($resultQueryToken->num_rows > 0) {
        $isLogin = true;
        $username = $resultQueryToken->fetch_assoc()['username'];
    }
} else {
    // Generate token jika belum ada cookie
    $accessLogin = bin2hex(random_bytes(16));
    setcookie('accessLogin', $accessLogin, time() + (86400 * 30), "/");
}

$category = $_GET['category'] ?? null;

if ($category === null) {
    $sql = "SELECT p.id, p.name, p.price, p.thumbnail, pc.category_name
            FROM products p
            JOIN product_categories pc ON pc.id = p.product_category_id
            WHERE p.is_publish = true";
    $stmt = $conn->prepare($sql);
} else {
    $sql = "SELECT p.id, p.name, p.price, p.thumbnail, pc.category_name
            FROM products p
            JOIN product_categories pc ON pc.id = p.product_category_id
            WHERE pc.category_name = ? AND p.is_publish = true";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
}

$stmt->execute();
$result = $stmt->get_result();
