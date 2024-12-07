<?php
include("database/connectdb.php");
// Số sản phẩm hiển thị trên mỗi trang
$products_per_page = 6;

// Lấy trang hiện tại từ URL, mặc định là trang 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);

// Tính toán offset
$offset = ($page - 1) * $products_per_page;

// Lấy tổng số sản phẩm
$stmt = $con->prepare("SELECT COUNT(*) AS total FROM products");
$stmt->execute();
$total_products = $stmt->fetchColumn();

// Tính tổng số trang
$total_pages = ceil($total_products / $products_per_page);

// Lấy dữ liệu sản phẩm cho trang hiện tại
$stmt = $con->prepare("SELECT * FROM products LIMIT :offset, :limit");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $products_per_page, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll();
?>
