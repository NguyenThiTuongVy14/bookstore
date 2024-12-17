<style>
/* #id th{
    background-color: #FFC6C6;
    
}*/
.table th, .table td {
        border: 1px solid #ccc;
        text-align: center;
    } 

</style>
<div class="container mt-4">
    <h3 class="text-center text-success">TẤT CẢ ĐƠN HÀNG</h3>
    <div class="col-12 d-flex justify-content-center btn-custom">
        <a href="../export/order-list.php" class="btn nav-link text-light">EXPORT</a>
    </div>

    <table class="table mt-5">
        <thead class="table-dark">
            <tr id="id">
                <th>STT</th>
                <th>ID Người đặt</th>
                <th>Số hóa đơn</th>
                <th>Tổng tiền</th>
                <th>Ngày đặt</th>
                <th>Chi tiết hóa đơn</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('../database/connectdb.php'); 

            // Truy vấn lấy tất cả đơn hàng
            $get_orders_query = "SELECT * FROM `user_orders`";
            $stmt = $con->prepare($get_orders_query);
            $stmt->execute();

            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $row_count = count($orders);

            if ($row_count == 0) {
                echo "<h2 class='text-danger text-center mt-5'>KHÔNG CÓ ĐƠN HÀNG NÀO!</h2>";
            } else {
                $number = 0;
                foreach ($orders as $row_data) {
                    $order_id = $row_data['order_id'];
                    $user_id = $row_data['user_id'];
                    $amount_due = number_format($row_data['total_price'], 0, ',', '.'); // Định dạng tiền
                    $invoice_number = $row_data['invoice_number'];
                    $order_date = $row_data['order_date'];
                    $order_status = $row_data['order_status'];
                    $number++;

                    $status_label = '';
                    $button_status='';
                    if ($order_status == 'pending') {
                        $status_label = "<span class='badge badge-warning'>Chờ xử lý</span>";
                        $button_status="<a href='index.php?confirm_order=$order_id' class='btn btn-success btn-sm'>Xác nhận</a>
                        <a href='index.php?cancel_order=$order_id' class='btn btn-danger btn-sm'>Hủy</a>";
                    } elseif ($order_status == 'confirmed') {
                        $status_label = "<span class='badge badge-info'>Đã xác nhận</span>";
                    } elseif ($order_status == 'cancelled') {
                        $status_label = "<span class='badge badge-dark'>Đã hủy</span>";
                    }

                    echo "<tr id='order-$order_id'>
                            <td>$number</td>
                            <td>$user_id</td>
                            <td>$invoice_number</td>
                            <td>$amount_due VND</td>
                            <td>$order_date</td>
                            <td><button class='btn btn-info btn-sm' onclick='showOrderDetails($order_id)'>Chi tiết</button></td>
                            <td>$status_label</td>
                            <td>$button_status</td>
                          </tr>";

                    // Div này sẽ chứa chi tiết của mỗi đơn hàng
                    echo "<tr id='order-details-$order_id' class='order-details' style='display: none;'>
                            <td colspan='8'>
                                <div class='loading' id='loading-$order_id' style='display:none;'>Đang tải...</div>
                                <div id='order-details-content-$order_id'></div>
                            </td>
                          </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function showOrderDetails(orderId) {
        $('#order-details-' + orderId).toggle();

        $('#loading-' + orderId).show();
        $('#order-details-content-' + orderId).html('');

        $.ajax({
            url: 'module/order/get_order_details.php', 
            method: 'GET',
            data: { order_id: orderId },
            success: function(response) {
                $('#loading-' + orderId).hide();
                $('#order-details-content-' + orderId).html(response);
            },
            error: function() {
                $('#loading-' + orderId).hide();
                $('#order-details-content-' + orderId).html('<p class="text-danger">Lỗi khi tải chi tiết đơn hàng!</p>');
            }
        });
    }
</script>
