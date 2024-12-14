<?php
include('./database/connectdb.php');
session_start();

// Lấy thông tin đơn hàng từ bảng user_orders
$stmt = $con->prepare("SELECT * FROM user_orders WHERE user_id = :user_id");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$order = $stmt->fetchAll(PDO::FETCH_ASSOC);
var_dump($order);
echo'<br>';
exit;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
</head>
<body>
    <h1>Chi tiết đơn hàng #<?php echo $order['invoice_number']; ?></h1>
    <p><strong>Số sản phẩm:</strong> <?php echo $order['total_products']; ?></p>
    <p><strong>Trạng thái:</strong> <?php echo $order['order_status']; ?></p>
    <p><strong>Tổng giá trị đơn hàng:</strong> <?php echo number_format($order['total_price'], 2); ?> VNĐ</p>

    <h3>Danh sách sản phẩm</h3>
    <table>
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_details as $detail) { ?>
                <tr>
                    <td><?php echo $detail['product_title']; ?></td>
                    <td><img src="./asset/img/<?php echo $detail['product_image1']; ?>" alt="" width="50"></td>
                    <td><?php echo $detail['quantity']; ?></td>
                    <td><?php echo number_format($detail['price'], 2); ?> VNĐ</td>
                    <td><?php echo number_format($detail['quantity'] * $detail['price'], 2); ?> VNĐ</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    
</body>
</html> 

