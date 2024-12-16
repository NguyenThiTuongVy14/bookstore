<?php
include('./database/connectdb.php');
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Lấy tất cả các đơn hàng của người dùng
    $stmt = $con->prepare("SELECT * FROM user_orders WHERE user_id = :user_id ORDER BY order_id DESC");
    $stmt->execute(['user_id' => $user_id]);
    $trangthai='';
    if ($stmt->rowCount() > 0) {
        echo "<div class='order-list'>";
        while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $order_id = $order['order_id'];
            if($order['order_status']=='pending'){
                $trangthai='Đang chờ xử lý';
            }
            else if($order['order_status']=='confirmed'){
                $trangthai='Đã được xác nhận';
            }
            else{
                $trangthai= 'Đã bị hủy';
            }
            echo "<div class='order-card'>";
            echo "<h2>Đơn hàng #" . $order['invoice_number'] . " - Tổng giá trị: " . number_format($order['total_price'], 2) . " VNĐ</h2>";
            echo "<p><strong>Trạng thái:</strong> " . $order['order_status'] . "</p>";

            // Lấy chi tiết đơn hàng
            $stmt_details = $con->prepare("SELECT * FROM order_details WHERE order_id = :order_id");
            $stmt_details->execute(['order_id' => $order_id]);

            echo "<h3>Danh sách sản phẩm</h3>";
            echo "<table class='order-table'>";
            echo "<thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
            while ($detail = $stmt_details->fetch(PDO::FETCH_ASSOC)) {
                $product_id = $detail['product_id'];
                $stmt_product = $con->prepare("SELECT product_title, product_image1, product_price FROM products WHERE product_id = :product_id");
                $stmt_product->execute(['product_id' => $product_id]);
                $product = $stmt_product->fetch(PDO::FETCH_ASSOC);

                // Hiển thị thông tin sản phẩm chi tiết
                echo "<tr>";
                echo "<td>" . $product['product_title'] . "</td>";
                echo "<td><img src='./asset/img/" . $product['product_image1'] . "' alt='" . $product['product_title'] . "' width='50'></td>";
                echo "<td>" . $detail['total_product'] . "</td>";
                echo "<td>" . number_format($product['product_price'], 0,',','.') . " VNĐ</td>";
                echo "<td>" . number_format($detail['total_product'] * $product['product_price'], 0,',','.') . " VNĐ</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>"; 
        }
        echo "</div>"; 
        echo"<a href='index.php'><input type='submit' value='Tiếp tục mua sắm' class='btn bg-info px-3 py-1 border-0 mx-2' name='continue_shopping'> </a>";
    } else {
        echo "<p>Không có đơn hàng nào.</p>";
    }
}
?>
<style>
    /* CSS cơ bản cho giao diện */
body {
    font-family: 'Times New Roman', Times, serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.container {
    width: 80%;
    margin: 20px auto;
}

h2, h3 {
    color: #333;
    font-size: 1.5rem;
    margin: 10px 0;
}

.order-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.order-card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
    transition: transform 0.3s ease;
}

.order-card:hover {
    transform: translateY(-5px);
}

.order-card p {
    font-size: 1rem;
    color: #555;
    margin-top: 10px;
}

.order-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.order-table th, .order-table td {
    padding: 10px;
    text-align: center;
    border: 1px solid #ddd;
}

.order-table th {
    background-color: #f8f8f8;
    color: #333;
}

.order-table td img {
    border-radius: 5px;
}

.order-table td {
    background-color: #fafafa;
}

.order-card h3 {
    font-size: 1.2rem;
    color: #007bff;
}

.order-card .order-table td {
    font-size: 0.95rem;
}
.bg-info {
    background-color: #17a2b8;
    color: white;
    border: none;
}
</style>