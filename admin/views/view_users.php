<?php
$get_users = "SELECT * FROM `user_table`";
$stmt = $con->prepare($get_users);
$stmt->execute();
$row_count = $stmt->rowCount();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách user</title>
</head>
<body>
    <h3 class="text-center">
        KHÁCH HÀNG HIỆN CÓ
    </h3>
    <div class="col-12 d-flex justify-content-center">
        <button class="btn"><a href="./export/user-list.php" class="btn nav-link text-light bg-info my-1">EXPORT</a></button>
    </div>

    <table class="table table-bordered mt-5">
        <thead class="bg-info">
            <?php
            if ($row_count == 0) {
                echo "<h2 class='text-danger text-center mt-5'>KHÔNG CÓ USER NÀO</h2>";
            } else {
                echo "<tr>
                    <th>STT</th>
                    <th>Họ và tên khách hàng</th>
                    <th>Email khách hàng</th>
                    <th>Địa chỉ khách hàng</th>
                    <th>Số điện thoại khách hàng</th>
                    <th>Xoá</th>
                </tr>
            </thead>
            <tbody>";
                $number = 0;
                while ($row_data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $user_id = $row_data['user_id'];
                    $user_fullname = $row_data['user_fullname'];
                    $user_email = $row_data['user_email'];
                    $user_address = $row_data['user_address'];
                    $user_mobile = $row_data['user_mobile'];
                    $number++;
                    echo "<tr>
                        <td>$number</td>
                        <td>$user_fullname</td>
                        <td>$user_email</td>
                        <td>$user_address</td>
                        <td>$user_mobile</td>
                        <td><a href='javascript:void(0);' onclick='confirmDelete($user_id)'><i class='fa-solid fa-trash text-danger'></i></a></td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <script>
    function confirmDelete(user_id) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa tài khoản này?',
            text: "Bạn sẽ không thể khôi phục lại sau khi xóa!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php?delete_users=' + user_id;
            }
        });
    }
</script>
</body>

</html>
