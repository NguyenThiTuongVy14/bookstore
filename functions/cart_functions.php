<?php
// cart_functions.php

// Hàm tính tổng giá trị giỏ hàng
function get_cart_total_price($pdo, $ip_address) {
    $total_price = 0;
    $stmt = $pdo->prepare("SELECT * FROM `cart_details` WHERE ip_address = :ip_address");
    $stmt->execute(['ip_address' => $ip_address]);
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $product_id = $row['product_id'];
        // Lấy thông tin sản phẩm
        $stmt_product = $pdo->prepare("SELECT product_price FROM `products` WHERE product_id = :product_id");
        $stmt_product->execute(['product_id' => $product_id]);
        $row_product_price = $stmt_product->fetch(PDO::FETCH_ASSOC);
        $product_price = $row_product_price['product_price'];
        $quantity = $row['quantity'];
        $total_price += $product_price * $quantity;
    }
    return $total_price;
}

// Hàm cập nhật giỏ hàng
function update_cart($pdo, $ip_address, $cart_data) {
    foreach ($cart_data as $product_id => $quantity) {
        $quantity = intval($quantity);
        $stmt = $pdo->prepare("UPDATE `cart_details` SET quantity = :quantity WHERE ip_address = :ip_address AND product_id = :product_id");
        $stmt->execute([
            'quantity' => $quantity,
            'ip_address' => $ip_address,
            'product_id' => $product_id
        ]);
    }
}

// Hàm xóa sản phẩm khỏi giỏ hàng
function remove_cart_item($pdo, $ip_address, $remove_items) {
    foreach ($remove_items as $product_id) {
        $stmt = $pdo->prepare("DELETE FROM `cart_details` WHERE product_id = :product_id AND ip_address = :ip_address");
        $stmt->execute([
            'product_id' => $product_id,
            'ip_address' => $ip_address
        ]);
    }
}
?>
