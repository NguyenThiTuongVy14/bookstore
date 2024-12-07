<?php
include("../database/connectdb.php")
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem danh sách danh mục</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
</head>

<body>
    <div class="row">
        <h3>
            <div class="text-center text-success">DANH SÁCH DANH MỤC</div>
        </h3>
        <div class="col-12 d-flex justify-content-center">
            <button class="btn"><a href="index.php?insert_categories" class="btn nav-link text-light bg-info my-1">Thêm
                    danh mục</a></button>
        </div>
    </div>

    <table class=" table table-bordered mt-5 text-center">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên danh mục</th>
                <th>Chỉnh sửa</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $get_category = "SELECT * FROM `danhmuc`";
            $stmt = $con->prepare($get_category);
            $stmt->execute();
            $row_categories_all = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stt = 0;
            foreach ($row_categories_all as $row_category) {
                $stt++;
                $category_id = $row_category['danhmuc_id'];
                $category_name = $row_category['danhmuc_title'];
                ?>
                <tr>
                    <td><?php echo $stt; ?></td>
                    <td><?php echo $category_name; ?></td>
                    <td>
                        <a href="index.php?edit_category=<?php echo $category_id ?>"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                    </td>
                    <td>
                        <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $category_id; ?>)"><i
                                class="fa-solid fa-trash text-danger"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <script>
        function confirmDelete(categoryId) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa danh mục này?',
                text: "Bạn sẽ không thể khôi phục lại sau khi xóa!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?delete_category=' + categoryId;
                }
            });
        }
    </script>
</body>

</html>