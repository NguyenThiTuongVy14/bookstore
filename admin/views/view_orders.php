<div class="container mt-4">
    <h3 class="text-center text-success">TẤT CẢ ĐƠN HÀNG</h3>
    <div class="col-12 d-flex justify-content-center btn-custom">
        <a href="./export/order-list.php" class="btn nav-link text-light">EXPORT</a>
    </div>

    <table class="table table-bordered mt-5">
        <thead class="bg-info text-light">
            <?php
            include('../database/connectdb.php'); // Kết nối CSDL

            // Truy vấn lấy tất cả đơn hàng
            $get_orders_query = "SELECT * FROM `user_orders`";
            $stmt = $con->prepare($get_orders_query);
            $stmt->execute();

            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $row_count = count($orders);

            if ($row_count == 0) {
                echo "<h2 class='text-danger text-center mt-5'>KHÔNG CÓ ĐƠN HÀNG NÀO!</h2>";
            } else {
                echo "<tr>
                            <th>STT</th>
                            <th>ID Người đặt</th>
                            <th>Tổng tiền</th>
                            <th>Số hoá đơn</th>
                            <th>Tổng số lượng</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>";
            }
            ?>
        </thead>
        <tbody>
            <?php
            // Hiển thị các đơn hàng
            if ($row_count > 0) {
                $number = 0;
                foreach ($orders as $row_data) {
                    $order_id = $row_data['order_id'];
                    $user_id = $row_data['user_id'];
                    $amount_due = number_format($row_data['amount_due'], 0, ',', '.'); // Định dạng tiền
                    $invoice_number = $row_data['invoice_number'];
                    $total_products = $row_data['total_products'];
                    $order_date = $row_data['order_date'];
                    $order_status = $row_data['order_status'];
                    $number++;

                    $status_button = '';
                    $status_label = '';

                    if ($order_status == 'pending') {
                        $status_label = "<span class='badge badge-warning'>Chờ xử lý</span>";
                        $status_button = "<a href='index.php?confirm_order=$order_id' class='btn btn-success btn-sm'>Xác nhận</a>
                                          <a href='index.php?cancel_order=$order_id' class='btn btn-danger btn-sm'>Hủy</a>";
                    } elseif ($order_status == 'confirmed') {
                        $status_label = "<span class='badge badge-info'>Đã xác nhận</span>";
                    } elseif ($order_status == 'cancelled') {
                        $status_label = "<span class='badge badge-dark'>Đã hủy</span>";
                    }

                    echo "<tr>
                                <td>$number</td>
                                <td>$user_id</td>
                                <td>$amount_due VND</td>
                                <td>$invoice_number</td>
                                <td>$total_products</td>
                                <td>$order_date</td>
                                <td>$status_label</td>
                                <td>$status_button</td>
                            </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>
