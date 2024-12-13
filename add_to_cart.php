<?php 
session_start();
include("database/connectdb.php");
include("functions/function.php");


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = null;
}

if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];
    $quantity=1;
    update_cart($con, $user_id, $product_id, $quantity);

    header("Location: cart.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>