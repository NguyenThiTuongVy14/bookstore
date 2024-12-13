<?php
session_start();

include('../database/connectdb.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $con->prepare("SELECT * FROM user_table WHERE user_email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['user_password'])) {
            $_SESSION['user_fullname'] = $user['user_fullname'];
            $_SESSION['user_id'] =$user['user_id'];
            header("Location: ../index.php");
            exit();
        } else {
            $error = "Thông tin đăng nhập không đúng!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
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
    <link rel="website icon" type="png" href="./asset/img/logo_black.png" id="logo" />
    <title>VT Store</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="content">
        <!-- Login Form -->
        <div class="login-container" id="loginForm">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-md-5 mt-md-4 pb-5">
                        <h2 class="fw-bold mb-2 text-uppercase">Đăng nhập</h2>
                        <?php if ($error)
                            echo "<div class='alert alert-danger'>$error</div>"; ?>
                        <form action="" method="post">
                            <div class="form-outline form-white mb-4 mt-5">
                                <input type="email" name="email" class="form-control form-control-lg"
                                    placeholder="Email" required />
                            </div>
                            <div class="form-outline form-white mb-4">
                                <input type="password" name="password" class="form-control form-control-lg"
                                    placeholder="Mật khẩu" required />
                            </div>
                            <button class="btn btn-outline-light btn-lg px-5" type="submit" name="login">Đăng
                                nhập</button>
                        </form>
                        <div class="d-flex justify-content-center text-center mt-4 pt-1 social-icons">
                            <p>Đăng nhập với nhà cung cấp khác:&nbsp;&nbsp;</p>
                            <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                        </div>
                    </div>
                    <div>
                        <p class="mb-0">Đăng ký tài khoản mới? <a href="dangky.php"
                                class="text-white-50 fw-bold">Đăng ký</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>