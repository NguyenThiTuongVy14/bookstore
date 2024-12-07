<!-- header.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-eOJMYsd53ii+dfh6GLmZJIoU8HfAX5t9y7duGqkiWSq5I3n+oRtq4ByfG5trF5J"
        crossorigin="anonymous"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="website icon" type="png" href="asset/img/logo.png" id="logo" />
    <title>VT Store</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body>
    <!-- Navbar -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-dark text-light shadow" data-bs-theme="dark">
            <div class="container-fluid">
                <a href="./index.php" class="navbar-brand">
                    <img src="./asset/img/logo.png" alt="logo" class="nav_logo" width="100px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./index.php">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="display_all.php">Sản phẩm</a>
                        </li>
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo "<li class='nav-item'>
                                    <a class='nav-link' href='./users_area/profile.php'>Trang cá nhân</a>
                                </li>";
                        } else {
                            echo "<li class='nav-item'>
                                    <a class='nav-link' href='./users_area/user_registration.php'>Đăng ký</a>
                                </li>";
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Liên hệ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">
                                <i class="fa-solid fa-cart-shopping"></i><sup>
                                    <?php cart_item(); ?>
                                </sup>
                            </a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search" action="search_product.php" method="get">
                        <input class="form-control me-2 bg-secondary text-light" type="search"
                            placeholder="Nhập tên sản phẩm" aria-label="Search" name="search_data">
                        <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <!-- Scroll to Top Button -->
    <button onclick="topFunction()" id="topbTN" title="Go to top" class="btn btn-dark shadow">
        <i class="fa-solid fa-arrow-up-long"></i>
    </button>

    <!-- Banner Section and Sidebar -->
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Banner Section -->
            <div class="col-lg-9 ps-0">
                <div class="h-100 rounded shadow overflow-hidden">
                    <img src="./asset/img/banner7.png" alt="Banner" class="img-fluid w-100 h-100"
                        style="object-fit: cover;">
                </div>
            </div>

            <!-- Sidebar Section -->
            <div class="col-lg-3 bg-dark text-light p-3 rounded shadow d-flex flex-column" style="height: 80vh;">
                <div class="mb-4 flex-grow-1" style="overflow-y: auto; max-height: 50%;">
                    <ul class="navbar-nav text-center">
                        <li class="nav-item bg-primary" style="position: sticky; top: 0; z-index: 1;">
                            <a href="#" class="nav-link text-light py-2">
                                <h4>DANH MỤC</h4>
                            </a>
                        </li>
                        <?php getCat(); ?>
                    </ul>
                </div>

                <!-- Publishers -->
                <div class="flex-grow-1" style="overflow-y: auto; max-height: 50%;">
                    <ul class="navbar-nav text-center">
                        <li class="nav-item bg-primary" style="position: sticky; top: 0; z-index: 1;">
                            <a href="#" class="nav-link text-light py-2">
                                <h4>NHÀ XUẤT BẢN</h4>
                            </a>
                        </li>
                        <?php getBrands(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>


</body>

</html>