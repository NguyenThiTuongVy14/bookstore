<?php 
if(isset($_GET['confirm_order'])){
    $order_id=$_GET['confirm_order'];
    try {
        $oder_confirm_query="UPDATE `user_orders` SET `order_status` = 'confirmed' WHERE order_id = :order_id";
        $stmt=$con->prepare($oder_confirm_query);
        $stmt->bindParam(":order_id",$order_id);
        $stmt->execute();

        header("Location: index.php?list_orders&status=confirmed");
        exit();
    } catch (PDOException $e) {
        echo "Lỗi khi xác nhận đơn hàng:  ".$e->getMessage();
    }
}
?>