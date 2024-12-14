<?php

function cart_item($user_id) {
    global $con;
    if (empty($user_id)) {
        return 0;
    }

    try {
        $stmt = $con->prepare("SELECT count(quantity) AS total_quantity FROM `cart_details` WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return isset($result['total_quantity']) ? $result['total_quantity'] : 0;

    } catch (PDOException $e) {
        return 0;
    }
}



function get_cart_total_price($pdo, $user_id = null) {
    if ($user_id !== null) {
        $total_price = 0;
        $stmt = $pdo->prepare("SELECT c.quantity, p.product_price FROM cart_details c JOIN products p ON c.product_id = p.product_id WHERE c.user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $total_price += $row['quantity'] * $row['product_price'];
        }

        return $total_price;
    } else {
        $total_price = 0;

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                $stmt_product = $pdo->prepare("SELECT product_price FROM products WHERE product_id = :product_id");
                $stmt_product->execute(['product_id' => $product_id]);
                $row_product = $stmt_product->fetch(PDO::FETCH_ASSOC);

                if ($row_product) {
                    $total_price += $row_product['product_price'] * $quantity;
                }
            }
        }

        return $total_price;
    }
}
function update_cart($con, $user_id, $product_id, $quantity) {
    if ($quantity <= 0) {
        return false; 
    }

    if ($user_id) {
        // Khi người dùng đã đăng nhập, lưu giỏ hàng vào cơ sở dữ liệu
        $stmt = $con->prepare("SELECT * FROM `cart_details` WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);

        if ($stmt->rowCount() > 0) {
            // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng
            $update_stmt = $con->prepare("UPDATE `cart_details` SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id");
            $update_stmt->execute(['quantity' => $quantity, 'user_id' => $user_id, 'product_id' => $product_id]);
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm vào giỏ
            $insert_stmt = $con->prepare("INSERT INTO `cart_details` (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
            $insert_stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'quantity' => $quantity]);
        }
    } else {
        // Khi người dùng chưa đăng nhập, lưu giỏ hàng vào session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }

    return true;
}
function remove_cart_item($pdo, $user_id, $product_id) {
    if ($user_id !== null) {
        $stmt = $pdo->prepare("DELETE FROM cart_details WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute([
            'user_id' => $user_id,
            'product_id' => $product_id
        ]);
    } else {
        unset($_SESSION['cart'][$product_id]); 
    }
}

function getProducts($page, $products_per_page, $category_id)
{
    global $con;
    $rows = getPaginatedProducts($page, $products_per_page, $category_id);
    foreach ($rows as $row) {
        $formatted_price = number_format($row['product_price'], 0, ',', '.');
        echo "
        <div class='col-md-4'>
            <div class='card'>
                <img src='./asset/img/{$row['product_image1']}' class='card-img-top' alt='#'>
                <div class='card-body'>
                    <h5 class='card-title'>{$row['product_title']}</h5>
                    <p class='card-text d-flex justify-content-between'>
                        <span style='margin-left: 10px; color: red; font-weight: bold;'>Giá: {$formatted_price}đ</span> 
                        <span style='margin-right: 10px;'>Đã bán: ";
        $get_sold_quantity = "SELECT SUM(quantity) AS total FROM orders_pending WHERE product_id = :product_id";
        $stmt = $con->prepare($get_sold_quantity);
        $stmt->bindParam(":product_id", $row['product_id'], PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_sold = $rows['total'];
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

function getPaginatedProducts($page, $products_per_page, $category_id)
{
    global $con;
    $offset = ($page - 1) * $products_per_page;
    if ($category_id) {
        $stmt = $con->prepare('SELECT * FROM products WHERE danhmuc_id = :danhmuc_id LIMIT :offset, :limit');
        $stmt->bindParam(':danhmuc_id', $category_id, PDO::PARAM_INT);
    } else {
        $stmt = $con->prepare('SELECT * FROM products LIMIT :offset, :limit');
    }

    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $products_per_page, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function generatePagination($con, $current_page, $products_per_page, $category_id)
{
    // Tính toán tổng số sản phẩm và tổng số trang
    $total_products_query = "SELECT COUNT(*) FROM products";
    if ($category_id) {
        $total_products_query .= " WHERE danhmuc_id = :danhmuc_id";
    }
    $stmt = $con->prepare($total_products_query);
    if ($category_id) {
        $stmt->bindParam(':danhmuc_id', $category_id, PDO::PARAM_INT);
    }
    $stmt->execute();
    $total_products = $stmt->fetchColumn();
    $total_pages = ceil($total_products / $products_per_page);

    if ($total_pages == 0) {
        $total_pages = 1;
    }


    $prev_page = ($current_page > 1) ? $current_page - 1 : 1;
    $next_page = ($current_page < $total_pages) ? $current_page + 1 : $total_pages;


    $category_param = isset($category_id) ? "&category_id={$category_id}" : '';

    if ($total_products > 6) {


        echo '<div class="pagination justify-content-center mt-3 mb-3">';


        if ($current_page > 1) {
            echo "<div class='page-item'>
                <a class='page-link' href='?page={$prev_page}{$category_param}'>Trang trước</a>
              </div>";
        }


        for ($i = 1; $i <= $total_pages; $i++) {
            $active_class = ($i == $current_page) ? 'active' : '';
            echo "<div class='page-item {$active_class}'>
                <a class='page-link' href='?page={$i}{$category_param}'>{$i}</a>
              </div>";
        }


        if ($current_page < $total_pages) {
            echo "<div class='page-item'>
                <a class='page-link' href='?page={$next_page}{$category_param}'>Trang sau</a>
              </div>";
        }

        echo '</div>';
    }
}


function getCat()
{
    global $con;

    $categories_query = "SELECT * FROM danhmuc";
    $stmt = $con->prepare($categories_query);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

    foreach ($categories as $category) {
        $active_class = ($category_id == $category['danhmuc_id']) ? 'active' : '';
        echo "
            <li class='nav-item'>
                <a href='?category_id={$category['danhmuc_id']}' class='nav-link text-light py-2 {$active_class}'>
                    {$category['danhmuc_title']}
                </a>
            </li>
        ";
    }
}



// Lấy nhà xuất bản
function getBrands()
{
    global $con;
    $stmt = $con->prepare("SELECT * FROM `nhaxuatban`");
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li class='nav-item'><a href='#' class='nav-link'>{$row['nxb_title']}</a></li>";
    }
}
?>
