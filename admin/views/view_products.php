<?php
    include('../database/connectdb.php');
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem danh sách sản phẩm</title>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- bootstrap javascript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        .button-middle {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>

    <div class="row">
        <h3 class="text-center text-success">DANH SÁCH SẢN PHẨM</h3>
        <div class="col-12 d-flex justify-content-center">
            <button class="btn"><a href="index.php?insert_product" class="btn nav-link text-light bg-info my-1">Thêm sản phẩm</a></button>
        </div>
    </div>

    <table class="table table-bordered mt-5 text-center">
        <div class="container mt-5">
            <?php
            // Truy vấn sản phẩm từ cơ sở dữ liệu
            $get_products = "SELECT * FROM `products`";
            $stmt = $con->prepare($get_products);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $number = 0;

            foreach ($products as $row) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_image1 = $row['product_image1'];
                $product_price = $row['product_price'];
                $status = $row['status'];
                $product_stock = $row['product_stock'];
                $number++;
            ?>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-3 mt-3">
                            <img src='./product_images/<?php echo htmlspecialchars($product_image1); ?>' class='img-fluid rounded-start' alt='Product Image'>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title text-success"><?php echo htmlspecialchars($product_title); ?></h5>
                                <p class="card-text">ID sản phẩm: <?php echo $product_id; ?></p>
                                <p class="card-text">Giá tiền: <?php echo number_format($product_price, 0, ',', thousands_separator: '.'); ?> VND</p>
                                <p class="card-text text-danger">Tổng được bán ra:
                                    <?php
                                    $get_sold_quantity = "SELECT SUM(quantity) as total_sold FROM `orders_pending` WHERE product_id = :product_id";
                                    $stmt_sold = $con->prepare($get_sold_quantity);
                                    $stmt_sold->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                                    $stmt_sold->execute();
                                    $row_sold_quantity = $stmt_sold->fetch(PDO::FETCH_ASSOC);
                                    $total_sold = $row_sold_quantity['total_sold'];
                                    echo $total_sold ? $total_sold : '0';
                                    ?>
                                </p>
                                <p class="card-text text-danger">Kho: <?php echo $product_stock; ?></p>
                                <a href='index.php?edit_products=<?php echo $product_id ?>' class='btn btn-primary'><i class='fa-solid fa-pen-to-square'></i> Chỉnh sửa</a>
                                <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $product_id; ?>)" class="btn btn-danger"><i
                                class="fa-solid fa-trash text-light"></i> Xóa
                        </a>                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </table>
    <script>
        function confirmDelete(product_id) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa sản phẩm này?',
                text: "Bạn sẽ không thể khôi phục lại sau khi xóa!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?delete_products='+product_id;
                }
            });
        }

    </script>
</body>

</html>
