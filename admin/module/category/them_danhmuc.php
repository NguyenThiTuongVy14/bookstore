<?php
include("../database/connectdb.php");

if (isset($_POST['btninsert_cat'])) {
    $danhmuc_title = $_POST['insert_cat'];
    $danhmuc_title=trim($danhmuc_title);
    $danhmuc_title=preg_replace('/\s+/', ' ', $danhmuc_title);
    $danhmuc_title=trim($danhmuc_title);
    $select_danhmuc_title = "SELECT * FROM `danhmuc` WHERE danhmuc_title = :danhmuc_title";
    $stmt = $con->prepare($select_danhmuc_title);
    $stmt->bindParam(':danhmuc_title', $danhmuc_title, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($danhmuc_title!=""){
        if (count($result) > 0) {
            echo "<script>
                    Swal.fire({
                        title: 'Đã có danh mục trong hệ thống',
                        icon: 'error',
                        showConfirmButton: true
                    });
                </script>";
        } else {
            $query_insert = "INSERT INTO `danhmuc` (danhmuc_title) VALUES (:danhmuc_title)";
            $stmt = $con->prepare($query_insert);
            $stmt->bindParam(':danhmuc_title', $danhmuc_title, PDO::PARAM_STR);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                echo "<script>
                Swal.fire({
                    title: 'Thêm danh mục thành công!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = 'index.php?view_categories'; 
                });
              </script>";
    
                
            } else {
                echo "<script>
                Swal.fire({
                    title: 'Thêm danh mục thất bại!',
                    icon: 'error',
                    showConfirmButton: true,
                })";
            }
        }
    }
    else{
        echo "<script>
                    Swal.fire({
                        title: 'Danh mục không được để trống',
                        icon: 'error',
                        showConfirmButton: true
                    }); 
                </script>";
    }
    
}
?>


<h2 class="text-center">Thêm Danh Mục</h2>
<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-primary" id="basic-addon1"><i class="fa-solid fa-receipt"
                style="color: #c3c3c3;"></i></span>
        <input type="text" class="form-control" name="insert_cat" placeholder="Tên danh mục" aria-label="danhmuc"
            aria-describedby="basic-addon1" required>
    </div>
    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="btn bg-primary text-light border-0 p-2 my-3" name="btninsert_cat"
            value="Thêm danh mục">
    </div>
</form>