<?php
require '../../connection.php';
$category = $_GET['category'] ?? null;

if ($category == null) {
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