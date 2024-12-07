<?php
if (isset($_GET['delete_brand'])) {
    $nxb_id=$_GET['delete_brand'];
    $delete_nxb_query="DELETE FROM `nhaxuatban` WHERE nxb_id = :nxb_id";
    $stmt=$con->prepare(($delete_nxb_query));
    $stmt->bindParam(":nxb_id",$nxb_id);
    if ($stmt->execute()>0) {
        echo "<script>
                Swal.fire({
                    title: 'Thành công!',
                    text: 'Nhà xuất bản đã được xóa!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(function () {
                    window.location.href='index.php?view_brands';
                })
            </script>";
    }else{
        echo "<script>Swal.fire('Lỗi!', 'Có lỗi xảy ra, không thể xóa nhà xuất bản.', 'error');</script>";
    }
}
?>
