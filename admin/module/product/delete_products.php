<?php
include("../database/connectdb.php");

if (isset($_GET['delete_products'])) {
    $delete_id=$_GET['delete_products'];
    try {
        $query = "DELETE FROM `products` WHERE product_id = :product_id";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':product_id', $delete_id, PDO::PARAM_INT);
        
        if ($stmt->execute()>0) {
            echo "<script>
                Swal.fire({
                    title: 'Thành công!',
                    text: 'Sản phẩm đã được xóa!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(function() {
                    window.location.href = 'index.php?view_products';
                });
              </script>";
        } else {
            echo "<script>Swal.fire('Lỗi!', 'Có lỗi xảy ra, không thể xóa sản phẩm.', 'error');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>Swal.fire('Lỗi!', 'Có lỗi xảy ra: " . $e->getMessage() . "', 'error');</script>";
    }
}
?>
