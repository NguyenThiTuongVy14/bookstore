
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
    <link rel="website icon" type="png" href="asset/img/logo_black.png" id="logo"/>
    <title>VT Store</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body>
<header class="header bg-dark">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="logo">
            <a href="index.php">
                <img src="asset/img/logo.png" alt="Logo" class="img-fluid">
            </a>
        </div>

        <div class="search-bar position-relative">
            <input type="text" class="form-control search-input" placeholder="Tìm kiếm sản phẩm...">
            <button class="btn search-button">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <div class="header-icons d-flex align-items-center">
            <a href="#" class="icon-link text-center">
                <i><img src="asset/img/contact-us.png" alt=""></i>
                <p>Liên hệ</p>
            </a>
            <a href="#" class="icon-link text-center">
                <i class="fas fa-shopping-cart"></i>
                <p>Giỏ Hàng</p>
            </a>

            <div class="icon-link text-center dropdown">
                <a href="#" class="dropdown-toggle" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user"></i>
                    <p id="accountStatus">Tài Khoản</p>
                </a>
                <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="accountDropdown">
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <li><a class="dropdown-item" href="#">Chào, <?php echo $_SESSION['user_name']; ?></a></li>
                        <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                    <?php else: ?>
                        <li><a class="dropdown-item" href="login.php">Đăng nhập</a></li>
                        <li><a class="dropdown-item" href="signup.php">Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</header>
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
                <div class="mb-4 flex-grow-1 list">
                    <ul class="navbar-nav text-center">
                        <li class="nav-item bg-primary" style="position: sticky; top: 0; z-index: 1;">
                            <a href="#" class="nav-link text-light py-2">
                                <h4>DANH MỤC</h4>
                            </a>
                        </li>
                        <?php getCat(); ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>


</body>


</html>