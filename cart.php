<?php
include('./database/connectdb.php');
include('./functions/function.php');
session_start();
   
// Lấy tổng giá trị giỏ hàng cho người dùng đã đăng nhập
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $total_price = get_cart_total_price($con, $user_id);
} else {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];  
    }
    $total_price = 0;
}

// Cập nhật giỏ hàng
if (isset($_POST['update_cart'])) {
    if (isset($_SESSION['user_id'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['qty'][$product_id];
        update_cart($con, $user_id, $product_id, $quantity);
    }
    foreach ($_POST['qty'] as $product_id => $quantity) {
        $_SESSION['cart'][$product_id] = $quantity;
    }
}

// Xóa sản phẩm khỏi giỏ hàng
if (isset($_POST['remove_cart'])) {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['user_id'])) {
        remove_cart_item($con, $user_id, $product_id);
    } else {
        unset($_SESSION['cart'][$product_id]);
    }
    header("Location: cart.php");
    exit();
}


if (isset($_POST['checkout'])) {
    if (isset($_SESSION['user_id'])) {
        // Đối với người dùng đã đăng nhập
        $user_id = $_SESSION['user_id'];
        $total_price = get_cart_total_price($con, $user_id);  
        $invoice_number = rand(100000, 999999);

        $stmt = $con->prepare("INSERT INTO user_orders (user_id, total_price, invoice_number, order_status) 
        VALUES (:user_id, :total_price, :invoice_number, :order_status)");
        $stmt->execute([
            'user_id' => $user_id,
            'total_price' => $total_price,
            'invoice_number' => $invoice_number,
            'order_status' => 'pending'  
        ]);

        $order_id = $con->lastInsertId();

        $stmt_cart = $con->prepare("SELECT * FROM `cart_details` WHERE user_id = :user_id");
        $stmt_cart->execute(['user_id' => $user_id]);
        while ($row = $stmt_cart->fetch(PDO::FETCH_ASSOC)) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];

            // Thêm chi tiết đơn hàng vào bảng `order_details`
            $stmt_order_details = $con->prepare("INSERT INTO order_details (order_id, product_id, total_product) 
                                                 VALUES (:order_id, :product_id, :total_product)");
            $stmt_order_details->execute([
                'order_id' => $order_id,
                'product_id' => $product_id,
                'total_product' => $quantity
            ]);
        }

        // Xóa giỏ hàng sau khi thanh toán
        $stmt_delete_cart = $con->prepare("DELETE FROM cart_details WHERE user_id = :user_id");
        $stmt_delete_cart->execute(['user_id' => $user_id]);

    } else {
        // Đối với khách hàng chưa đăng nhập
        $total_price = 0;
        $order_id = rand(100000, 999999); 

        $stmt = $con->prepare("INSERT INTO user_orders (user_id, total_price, invoice_number, order_status) 
        VALUES (NULL, :total_price, :invoice_number, :order_status)");
        $stmt->execute([
            'total_price' => $total_price,
            'invoice_number' => $order_id,
            'order_status' => 'pending'
        ]);

        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $stmt_order_details = $con->prepare("INSERT INTO order_details (order_id, product_id, total_product) 
                                                 VALUES (:order_id, :product_id, :total_product)");
            $stmt_order_details->execute([
                'order_id' => $order_id,
                'product_id' => $product_id,
                'total_product' => $quantity
            ]);
        }

        unset($_SESSION['cart']);
    }

    header("Location: order_details.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="stylecart.css">
</head>

<body>
    <div class="container mb-3 mt-3">
        <div class="row">
            <form action="" method="post">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Hình sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Thành tiền</th>
                            <th colspan="2">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_price = 0;
                        $result_count = 0;
                        if (isset($_SESSION['user_id'])) {
                            $stmt = $con->prepare("SELECT * FROM `cart_details` WHERE user_id = :user_id");
                            $stmt->execute(['user_id' => $user_id]);
                            $result_count = $stmt->rowCount();
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $product_id = $row['product_id'];
                                    $stmt_product = $con->prepare("SELECT product_title, product_image1, product_price FROM `products` WHERE product_id = :product_id");
                                    $stmt_product->execute(['product_id' => $product_id]);
                                    $row_product = $stmt_product->fetch(PDO::FETCH_ASSOC);

                                    $product_title = $row_product['product_title'];
                                    $product_image1 = $row_product['product_image1'];
                                    $product_price = $row_product['product_price'];
                                    $quantity = $row['quantity'];
                                    $total_price += $product_price * $quantity;
                                    ?>
                                    <tr>
                                        <td><?php echo $product_title; ?></td>
                                        <td><img src="./asset/img/<?php echo $product_image1; ?>" alt="" class="cart_img"></td>
                                        <td>
                                            <input type="text" name="qty[<?php echo $product_id; ?>]" class="form-input w-50"
                                                value="<?php echo $quantity; ?>">
                                        </td>
                                        <td><?php echo number_format($product_price, 2); ?> VNĐ</td>
                                        <td><?php echo number_format($product_price * $quantity, 2); ?> VNĐ</td>
                                        <td>
                                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                            <input type="submit" value="Cập nhật giỏ hàng"
                                                class="btn bg-info px-3 py-1 border-0 mx-2 text-light" name="update_cart">
                                        </td>
                                        <td>
                                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                            <input type="submit" value="Xoá khỏi giỏ hàng"
                                                class="btn bg-danger text-light px-3 py-1 border-0 mx-2" name="remove_cart">
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<h2 class='text-center text-danger'>Giỏ hàng rỗng</h2>";
                            }
                        } else {
                            if (!empty($_SESSION['cart'])) {
                                foreach ($_SESSION['cart'] as $product_id => $quantity) {
                                    $stmt_product = $con->prepare("SELECT product_title, product_image1, product_price FROM `products` WHERE product_id = :product_id");
                                    $stmt_product->execute(['product_id' => $product_id]);
                                    $row_product = $stmt_product->fetch(PDO::FETCH_ASSOC);

                                    $product_title = $row_product['product_title'];
                                    $product_image1 = $row_product['product_image1'];
                                    $product_price = $row_product['product_price'];
                                    $total_price += $product_price * $quantity;
                                    ?>
                                    <tr>
                                        <td><?php echo $product_title; ?></td>
                                        <td><img src="./asset/img/<?php echo $product_image1; ?>" alt="" class="cart_img"></td>
                                        <td>
                                            <input type="text" name="qty[<?php echo $product_id; ?>]" class="form-input w-50"
                                                value="<?php echo $quantity; ?>">
                                        </td>
                                        <td><?php echo number_format($product_price, 2); ?> VNĐ</td>
                                        <td><?php echo number_format($product_price * $quantity, 2); ?> VNĐ</td>
                                        <td>
                                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                            <input type="submit" value="Cập nhật giỏ hàng"
                                                class="btn bg-info px-3 py-1 border-0 mx-2 text-light" name="update_cart">
                                        </td>
                                        <td>
                                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                            <input type="submit" value="Xoá khỏi giỏ hàng"
                                                class="btn bg-danger text-light px-3 py-1 border-0 mx-2" name="remove_cart">
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<h2 class='text-center text-danger'>Giỏ hàng rỗng</h2>";
                            }
                        }
                        ?>
                    </tbody>
                </table>

                <div class="d-flex mb-5 mt-5">
                    <?php
                    if ($result_count > 0 || !empty($_SESSION['cart'])) {
                        echo "<h4 class='px-3'>Tổng số tiền: <strong class='text-danger'>" . number_format($total_price, 2) . " VNĐ</strong></h4>";
                        echo "<input type='submit' value='Tiếp tục mua sắm' class='btn bg-secondary text-light px-3 py-1 border-0 mx-2' name='continue_shopping'>"; 
                        echo "<button class='btn bg-danger px-3 py-2 border-0 text-light' type='submit' name='checkout'>Thanh toán giỏ hàng</button>";
                    } else {
                        echo "<input type='submit' value='Tiếp tục mua sắm' class='btn bg-info px-3 py-1 border-0 mx-2' name='continue_shopping'>"; 
                    }

                    if (isset($_POST['continue_shopping'])) {
                        echo "<script>window.open('index.php', '_self');</script>";
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
