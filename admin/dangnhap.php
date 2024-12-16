<?php
session_start();
include("../database/connectdb.php");

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $con->prepare('SELECT * FROM admin_table WHERE username = :admin_username');
        $stmt->bindParam('admin_username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && sha1($password) == $result['admin_password']) {
            $_SESSION['admin_username'] = $username;
            header('Location: index.php');
            exit();
        } else {
            $error = "Thông tin đăng nhập không đúng!";
        }
    }
}



?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Đăng Nhập Admin</title>

    <link rel="stylesheet" href="dangnhap.css">

</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <div class="logo">
                <img src="../asset/img/logo.png" alt="" width="100px">
            </div>
            <h2>Đăng Nhập Admin</h2>
            <?php if ($error)
                echo $error;
            ?>

            <form method="POST">
                <div class="textbox">
                    <input type="text" placeholder="Tên đăng nhập" name="username" required>
                </div>
                <div class="textbox">
                    <input type="password" placeholder="Mật khẩu" name="password" required>
                </div>
                <div class="btn-container">
                    <button type="submit" name="submit" class="btn-login">Đăng Nhập</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>