<?php

function cart_item() {
    // Kiểm tra số lượng sản phẩm trong giỏ hàng
    global $con, $user_id;
    $stmt = $con->prepare("SELECT * FROM `cart_details` WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $result_count = $stmt->rowCount();
    echo $result_count; 
}

function total_cart_price() {
    // Tính tổng giá trị giỏ hàng
    global $con, $user_id;
    $stmt = $con->prepare("SELECT * FROM `cart_details` WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $total_price = 0;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $product_id = $row['product_id'];
        $stmt_product = $con->prepare("SELECT product_price FROM `products` WHERE product_id = :product_id");
        $stmt_product->execute(['product_id' => $product_id]);
        $product = $stmt_product->fetch(PDO::FETCH_ASSOC);
        $total_price += $product['product_price'] * $row['quantity'];
    }

    echo number_format($total_price, 0, ',', '.');
}
function getProducts() {
    global $con;
    global $products;
    foreach ($products as $row) {
        $formatted_price = number_format($row['product_price'], 0, ',', '.');
        echo "
        <div class='col-md-4'>
            <div class='card'>
                <img src='./asset/img/{$row['product_image1']}' class='card-img-top' alt='...'>
                <div class='card-body'>
                    <h5 class='card-title'>{$row['product_title']}</h5>
                    <p class='card-text d-flex justify-content-between'>
                        <span style='margin-left: 10px; color: red; font-weight: bold;'>Giá: {$formatted_price}đ</span> 
                        <span style='margin-right: 10px;'>Đã bán: ";
                            $get_sold_quality = "SELECT SUM(quantity) AS total FROM orders_pending WHERE product_id = :product_id";
                            $stmt= $con->prepare("$get_sold_quality");
                            $stmt->bindParam(":product_id", $row['product_id'], PDO::PARAM_STR);
                            $stmt->execute();
                            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                            $total_sold=$rows['total'];
                            echo $total_sold ? $total_sold : '0';
        echo "          </span>
                    </p>
                    <a href='add_to_cart.php?product_id={$row['product_id']}' class='btn btn-primary'>Mua hàng</a>
                </div>
            </div>
        </div>
        ";
    }
}

// Lấy danh mục sản phẩm
    function getCat() {
        global $con;
        $stmt = $con->prepare("SELECT * FROM `danhmuc`");
        $stmt->execute();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li class='nav-item' ><a href='#' class='nav-link' >{$row['danhmuc_title']}</a></li>";
        }
    }

// Lấy nhà xuất bản (thương hiệu)
function getBrands() {
    global $con;
    $stmt = $con->prepare("SELECT * FROM `nhaxuatban`");
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li class='nav-item'><a href='#' class='nav-link'>{$row['nxb_title']}</a></li>";
    }
}
?>
<style>
    div{
        
    }
</style>