<?php
include('../../../database/connectdb.php'); 

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $stmt = $con->prepare("SELECT * FROM order_details WHERE order_id = :order_id");
    $stmt->execute(['order_id' => $order_id]);
    $details = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($details) > 0) {
        echo "<table class='table' width='100%'>
                <thead >
                    <tr>
                        <th width='50%' scope='col'>Tên sản phẩm</th>
                        <th width='10%' scope='col'>Số lượng</th>
                        <th width='20%' scope='col'>Giá</th>
                        <th width='20%' scope='col'>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>";

        foreach ($details as $detail) {
            $product_id = $detail['product_id'];
            $stmt_product = $con->prepare("SELECT product_title, product_price FROM products WHERE product_id = :product_id");
            $stmt_product->execute(['product_id' => $product_id]);
            $product = $stmt_product->fetch(PDO::FETCH_ASSOC);

            $total_price = $detail['total_product'] * $product['product_price'];

            echo "<tr>
                    <td>{$product['product_title']}</td>
                    <td>{$detail['total_product']}</td>
                    <td>" . number_format($product['product_price'], 0, ',', '.') . " VND</td>
                    <td>" . number_format($total_price, 0, ',', '.') . " VND</td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p class='text-danger'>Không có chi tiết cho đơn hàng này.</p>";
    }
}
?>
