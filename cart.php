<?php
include('./database/connectdb.php');
include('./functions/function.php');
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $total_price = get_cart_total_price($con, $user_id);
} else {

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $total_price = 0;
}

if (isset($_POST['update_cart'])) {
    if (isset($_SESSION['user_id'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['qty'][$product_id];
        update_cart($con, $user_id, $product_id, $quantity);
        foreach ($_POST['qty'] as $product_id => $quantity) {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }
}

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
// Xử lý thanh toán
if (isset($_POST['checkout'])) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $product_id = $_POST['product_id'];
        $total_price = get_cart_total_price($con, $user_id);
        $quantity = $_POST['qty'][$product_id];
        foreach ($_POST['qty'] as $product_id => $quantity) {
            $_SESSION['cart'][$product_id] = $quantity;
        }
        //$total_products = is_array($_SESSION['cart']) ? count($_SESSION['cart']) : 0; 
        $invoice_number = rand(100000, 999999);
        $stmt = $con->prepare("INSERT INTO user_orders (user_id, total_price, invoice_number, total_products, order_status) 
                               VALUES (:user_id, :total_price, :invoice_number, :total_products, :order_status)");
        $stmt->execute([
            'user_id' => $user_id,
            'total_price' => $total_price,
            'invoice_number' => $invoice_number,
            'total_products' => $quantity,
            'order_status' => 'pending'  // Trạng thái đơn hàng ban đầu
        ]);

        // Lấy ID của đơn hàng vừa tạo
        $order_id = $con->lastInsertId();

        // Lưu chi tiết đơn hàng vào bảng order_details
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $stmt_check = $con->prepare("SELECT * FROM cart_details WHERE product_id = :product_id AND user_id = :user_id");
            $stmt_check->execute([
                'product_id' => $product_id,
                'user_id' => $user_id
            ]);

            if ($stmt_check->rowCount() > 0) {
                // Nếu sản phẩm đã tồn tại, cập nhật số lượng
                $stmt_update = $con->prepare("UPDATE cart_details SET quantity = quantity + :quantity WHERE product_id = :product_id AND user_id = :user_id");
                $stmt_update->execute([
                    'product_id' => $product_id,
                    'user_id' => $user_id,
                    'quantity' => $quantity
                ]);
            } else {
                // Nếu sản phẩm chưa tồn tại, chèn bản ghi mới
                $stmt_order_details = $con->prepare("INSERT INTO cart_details (product_id, user_id, quantity) 
                                         VALUES (:product_id, :user_id, :quantity)");
                $stmt_order_details->execute([
                    'product_id' => $product_id,
                    'user_id' => $user_id,
                    'quantity' => $quantity
                ]);
            }
        }

        // Xóa giỏ hàng sau khi thanh toán
        unset($_SESSION['cart']);

        // Chuyển hướng đến trang chi tiết đơn hàng
        header("Location: order_details.php?order_id=$order_id");
        exit();
    } else {
        // Nếu người dùng chưa đăng nhập
        header("Location: user/dangnhap.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

                            if ($result_count > 0) {
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
                                        <td><?php echo $product_price; ?></td>
                                        <td><?php echo $product_price * $quantity; ?></td>
                                        <td>
                                            <form action="" method="post">

                                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                                <input type="submit" value="Cập nhật giỏ hàng"
                                                    class="btn bg-info px-3 py-1 border-0 mx-2 text-light" name="update_cart">
                                            </form>
                                        </td>
                                        <td>
                                            <form action="" method="post">

                                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                                <input type="submit" value="Xoá khỏi giỏ hàng"
                                                    class="btn bg-danger text-light px-3 py-1 border-0 mx-2" name="remove_cart">
                                            </form>
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
                                        <td><?php echo $product_price * $quantity; ?></td>
                                        <td>
                                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                            <input type="submit" value="Cập nhật giỏ hàng"
                                                class="btn bg-info px-3 py-1 border-0 mx-2 text-light" name="update_cart">
                                        </td>
                                        <td>
                                            <input type="hidden" name="remove_cart" value="<?php echo $product_id; ?>">
                                            <input type="submit" value="Xoá khỏi giỏ hàng"
                                                class="btn bg-danger text-light px-3 py-1 border-0 mx-2">
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
                        echo "<h4 class='px-3'>Tổng số tiền: <strong class='text-danger'>$total_price</strong></h4>";
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