<?php

include ("database/connectdb.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM user_table WHERE user_email = :email";
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $result = $con->exec($query);

    if ($result > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            echo "Đăng nhập thành công!";
        } else {
            echo "Mật khẩu không chính xác!";
        }
    } else {
        echo "Không tìm thấy người dùng với email này.";
    }

    // Đóng kết nối
    $conn->close();
}
?>
