<?php
include("../database/connectdb.php");

if (isset($_GET['edit_category'])) {
    $category_id = $_GET['edit_category'];

    $get_category_query = "SELECT * FROM `danhmuc` WHERE `danhmuc_id` = :category_id";
    $stmt = $con->prepare($get_category_query);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        $category_name = $category['danhmuc_title'];
    } else {
        echo "Danh mục không tồn tại!";
        exit;
    }
}

if (isset($_POST['btnUpdate'])) {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];

    if (!empty($category_name)) {
        $update_category_query = "UPDATE `danhmuc` SET `danhmuc_title` = :category_name WHERE `danhmuc_id` = :category_id";
        $stmt = $con->prepare($update_category_query);

        $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Danh mục đã được cập nhật!',
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.href = 'index.php?view_categories'; // Chuyển hướng về danh sách danh mục
                    });
                  </script>";
        } else {
            echo "<script>Swal.fire('Lỗi!', 'Có lỗi xảy ra, không thể cập nhật danh mục.', 'error');</script>";
        }
    } else {
        echo "<script>Swal.fire('Lỗi!', 'Tên danh mục không được để trống!', 'error');</script>";
    }
}
?>
<h2 class="text-center">Chỉnh sửa Danh Mục</h2>
<form method="post" action="" class="mb-2">
    <div class="input-group w-90 mb-2" >
        <span class="input-group-text bg-primary" id="basic-addon1"><i class="fa-solid fa-receipt"style="color: #c3c3c3;"></i></span>
        <input type="text" name="category_name" id="category_name" class="form-control" value="<?php echo htmlspecialchars($category_name); ?>" required>
    </div>
    <div class="input-group w-10 mb-2 m-auto">
         <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
         <input type="submit" class="btn bg-primary text-light border-0 p-2 my-3" name="btnUpdate" value="Cập nhật">
    </div>
  
</form>

    