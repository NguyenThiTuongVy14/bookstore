<?php
if(isset($_GET['cancel_order']))
{
    $order_id=$_GET['cancel_order'];
    try {
        $oder_cancel_query="UPDATE `user_orders` SET order_status = 'cancelled' WHERE order_id = :order_id";
    
        $stmt=$con->prepare($oder_cancel_query);
        $stmt->bindParam(":order_id",$order_id);
        $stmt->execute();

        header("Location: index.php?list_orders&status=cancelled");
        exit();
    } catch (PDOException $e) {
        echo "Lỗi khi huỷ đơn hàng:  ".$e->getMessage();
    }
}

?>