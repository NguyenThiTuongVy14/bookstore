<?php
include('./includes/connect.php');
include('./functions/cart_functions.php');
session_start();

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Bạn cần đăng nhập để xem giỏ hàng'); window.location.href = './users_area/user_login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id']; // Lấy user_id từ session
$total_price = get_cart_total_price($pdo, $user_id); // Tính tổng giá trị giỏ hàng

// Xử lý cập nhật giỏ hàng
if (isset($_POST['update_cart'])) {
    update_cart($pdo, $user_id, $_POST['qty']);
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_POST['remove_cart'])) {
    remove_cart_item($pdo, $user_id, $_POST['removeitem']);
}
?>

<!-- HTML phần giỏ hàng -->
<div class="container mb-3 mt-3">
    <div class="row">
        <form action="" method="post">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Hình sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Xoá khỏi giỏ hàng</th>
                        <th colspan="2">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Lấy danh sách sản phẩm trong giỏ hàng của người dùng
                    $stmt = $pdo->prepare("SELECT * FROM `cart_details` WHERE user_id = :user_id");
                    $stmt->execute(['user_id' => $user_id]);
                    $result_count = $stmt->rowCount();

                    if ($result_count > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $product_id = $row['product_id'];
                            // Lấy thông tin sản phẩm
                            $stmt_product = $pdo->prepare("SELECT product_title, product_image1, product_price FROM `products` WHERE product_id = :product_id");
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
                                <td><input type="text" name="qty[<?php echo $product_id; ?>]" class="form-input w-50" value="<?php echo $quantity; ?>"></td>
                                <td><?php echo $product_price * $quantity; ?></td>
                                <td><input type="checkbox" name="removeitem[]" value="<?php echo $product_id; ?>"></td>
                                <td><input type="submit" value="Cập nhật giỏ hàng" class="btn bg-info px-3 py-1 border-0 mx-2 text-light" name="update_cart"></td>
                                <td><input type="submit" value="Xoá khỏi giỏ hàng" class="btn bg-danger text-light px-3 py-1 border-0 mx-2" name="remove_cart"></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<h2 class='text-center text-danger'>Giỏ hàng rỗng</h2>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- subtotal -->
            <div class="d-flex mb-5 mt-5">
                <?php
                if ($result_count > 0) {
                    echo "<h4 class='px-3'>Tổng số tiền: <strong class='text-danger'>$total_price</strong></h4>";
                    echo "<input type='submit' value='Tiếp tục mua sắm' class='btn bg-secondary text-light px-3 py-1 border-0 mx-2' name='continue_shopping'>";
                    echo "<button class='btn bg-danger px-3 py-2 border-0 text-light'><a href='./users_area/checkout.php' class='text-light text-decoration-none'>Thanh toán giỏ hàng</a></button>";
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
