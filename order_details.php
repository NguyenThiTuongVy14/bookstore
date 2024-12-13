<!-- <?php
include('./database/connectdb.php');
session_start();

$order_id = $_GET['order_id'];

// Lấy thông tin đơn hàng từ bảng user_orders
$stmt = $con->prepare("SELECT * FROM user_orders WHERE order_id = :order_id");
$stmt->execute(['order_id' => $order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

// Kiểm tra nếu đơn hàng tồn tại
if ($order) {
    // Lấy chi tiết đơn hàng từ bảng order_details
    $stmt_details = $con->prepare("SELECT od.*, p.product_title, p.product_image1 
                                   FROM order_details od 
                                   JOIN products p ON od.product_id = p.product_id 
                                   WHERE od.order_id = :order_id");
    $stmt_details->execute(['order_id' => $order_id]);
    $order_details = $stmt_details->fetchAll(PDO::FETCH_ASSOC);
}
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
    <p><strong>Tổng giá trị đơn hàng:</strong> <?php echo number_format($order['total_price'], 2); ?> VNĐ</p>
    <p><strong>Trạng thái:</strong> <?php echo $order['order_status']; ?></p>
    <p><strong>Số sản phẩm:</strong> <?php echo $order['total_products']; ?></p>

    <h3>Danh sách sản phẩm:</h3>
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
</html> -->
