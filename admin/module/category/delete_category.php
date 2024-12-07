<?php
if (isset($_GET['delete_category'])) {
    $category_id = $_GET['delete_category'];
    $delete_category_query = "DELETE FROM `danhmuc` WHERE `danhmuc_id` = :category_id";
    $stmt = $con->prepare($delete_category_query);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo "<script>
                Swal.fire({
                    title: 'Thành công!',
                    text: 'Danh mục đã được xóa!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(function() {
                    window.location.href = 'index.php?view_categories';
                });
              </script>";
    } else {
        echo "<script>Swal.fire('Lỗi!', 'Có lỗi xảy ra, không thể xóa danh mục.', 'error');</script>";
    }
}
?>
