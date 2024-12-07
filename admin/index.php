<?php
include('../database/connectdb.php');
// include('../functions/common_function.php');
// @session_start();
// if (!isset($_SESSION['admin_username'])) {
//     header("Location: admin_login.php"); // Redirect to login page
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- css file -->
    <link rel="stylesheet" href="style.css">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <!-- navbar -->
    <div class="container-fluid p-0">
        <div class="bg-primary">
            <h3 class="text-center p-2">TRANG QUẢN LÝ</h3>
        </div>
        <div class="row">
            <div class="col-md-12 bg-primary p-1 d-flex justify-content-center align-items-center">
                <div class="button text-center">
                    <!-- Navigation buttons -->
                    <button><a href="index.php?view_products" class="nav-link">Quản lý sản phẩm</a></button>

                    <button><a href="index.php?view_categories" class="nav-link">Quản lý danh mục</a></button>
                    
                    <button><a href="index.php?view_brands" class="nav-link">Quản lý nhà xuất bản</a></button>
                    
                    <button><a href="index.php?list_orders" class="nav-link">Tất cả đơn hàng</a></button>
                    
                    <button><a href="index.php?list_payments" class="nav-link">Phương thức thanh toán</a></button>
                    
                    <button><a href="index.php?view_users" class="nav-link">Danh sách khách hàng</a></button>

                    <button><a href="admin_logout.php" class="nav-link">Đăng xuất</a></button>
                </div>
            </div>
        </div>
        
        <!-- Fourth child -->
        <div class="container my-3">
            <?php
            //product
                if (isset($_GET['view_products'])) {
                    include('views/view_products.php');
                }
                if (isset($_GET['insert_product'])) {
                    include('module/product/them_sanpham.php');
                }
                if (isset($_GET['delete_products'])) {
                    include('module/product/delete_products.php');
                }
                if (isset($_GET['edit_products'])) {
                    include('module/product/edit_products.php');
                }
            //category
                if (isset($_GET['view_categories'])) {
                    include('views/view_categories.php');
                }
                if (isset($_GET['insert_categories'])) {
                    include('module/category/them_danhmuc.php');
                }
                if (isset($_GET['edit_category'])) {
                    include('module/category/edit_category.php');
                }
                if (isset($_GET['delete_category'])) {
                    include('module/category/delete_category.php');
                }
            //user
                if (isset($_GET['view_users'])) {
                    include('views/view_users.php');
                }
                if (isset($_GET['delete_users'])) {
                    include('delete_users.php');
                }
            //nxb
                if (isset($_GET['view_brands'])) {
                    include('views/view_brands.php');
                }
                if (isset($_GET['edit_brands'])) {
                    include('module/brand/edit_brands.php');
                }
                if (isset($_GET['delete_brand'])) {
                    include('module/brand/delete_brands.php');
                }
                if (isset($_GET['insert_brand'])) {
                    include('module/brand/them_nxb.php');
                }
                //oders
                if (isset($_GET['list_orders'])) {
                    include('views/view_orders.php');
                }
                if (isset($_GET['confirm_order'])) {
                    include('module/order/confirm_order.php');
                }
                if (isset($_GET['cancel_order'])) {
                    include('module/order/cancel_order.php');
                }
                if (isset($_GET['delete_orders'])) {
                    include('delete_orders.php');
                }
                if (isset($_GET['list_payments'])) {
                    include('list_payments.php');
                }
                if (isset($_GET['delete_payments'])) {
                    include('delete_payments.php');
                }
            ?>
        </div>
    </div>

    <!-- bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

</body>

</html>