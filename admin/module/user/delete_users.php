<?php
if (isset($_GET['delete_users'])) {
    $user_id = $_GET['delete_users'];
    $delete_user_query = "DELETE FROM `user_table` WHERE `user_id` = :user_id";
    $stmt = $con->prepare($delete_user_query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo "<script>
                Swal.fire({
                    title: 'Thành công!',
                    text: 'Tài khoản đã được xóa!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false 
                }).then(function() {
                    window.location.href = 'index.php?view_users';
                });
              </script>";
    } else {
        echo "<script>Swal.fire('Lỗi!', 'Có lỗi xảy ra, không thể xóa tài khoản.', 'error');</script>";
    }
}

?>