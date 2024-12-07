<?php
include('../database/connectdb.php'); 

if (isset($_GET['confirm_order'])) {
    $order_id = $_GET['confirm_order'];

    try {
        $update_status = "UPDATE `user_orders` SET `order_status` = 'confirmed' WHERE `order_id` = :order_id";
        $stmt = $con->prepare($update_status);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();

        header('Location: index.php?view_orders&status=confirmed');
        exit();
    } catch (PDOException $e) {
        echo "Lỗi khi xác nhận đơn hàng: " . $e->getMessage();
    }
}

if (isset($_GET['cancel_order'])) {
    $order_id = $_GET['cancel_order'];

    try {
        $update_status = "UPDATE `user_orders` SET `order_status` = 'cancelled' WHERE `order_id` = :order_id";
        $stmt = $con->prepare($update_status);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();

        header('Location: index.php?view_orders&status=cancelled');
        exit();
    } catch (PDOException $e) {
        echo "Lỗi khi hủy đơn hàng: " . $e->getMessage();
    }
}
?>
