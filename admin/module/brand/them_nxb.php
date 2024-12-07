<?php
include("../database/connectdb.php");

if (isset($_POST['btninsert_nxb'])) {
    $nxb_title = $_POST['insert_nxb'];
    $nxb_title=trim($nxb_title);
    $nxb_title=preg_replace('/\s+/', ' ', $nxb_title);
    $nxb_title=trim($nxb_title);
    $select_nxb_title = "SELECT * FROM `nhaxuatban` WHERE nxb_title = :nxb_title";
    $stmt = $con->prepare($select_nxb_title);
    $stmt->bindParam(':nxb_title', $nxb_title, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($nxb_title!=""){
        if (count($result) > 0) {
            echo "<script>
                    Swal.fire({
                        title: 'Đã có nhà xuất bản này trong hệ thống',
                        icon: 'error',
                        showConfirmButton: true
                    });
                </script>";
        } else {
            $query_insert = "INSERT INTO `nhaxuatban` (nxb_title) VALUES (:nxb_title)";
            $stmt = $con->prepare($query_insert);
            $stmt->bindParam(':nxb_title', $nxb_title, PDO::PARAM_STR);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                echo "<script>
                Swal.fire({
                    title: 'Thêm nhà xuất bản thành công!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = 'index.php?view_brands'; 
                });
              </script>";
    
                
            } else {
                echo "<script>
                Swal.fire({
                    title: 'Thêm nhà xuất bản thất bại!',
                    icon: 'error',
                    showConfirmButton: true,
                })";
            }
        }
    }
    else{
        echo "<script>
                    Swal.fire({
                        title: 'Tên nhà xuất bản không được để trống',
                        icon: 'error',
                        showConfirmButton: true
                    }); 
                </script>";
    }
    
}
?>


<h2 class="text-center">Thêm nhà xuất bản</h2>
<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-primary" id="basic-addon1"><i class="fa-solid fa-receipt"
                style="color: #c3c3c3;"></i></span>
        <input type="text" class="form-control" name="insert_nxb" placeholder="Tên nhà xuất bản" aria-label="nxb"
            aria-describedby="basic-addon1" required>
    </div>
    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="btn bg-primary text-light border-0 p-2 my-3" name="btninsert_nxb"
            value="Thêm nhà xuất bản">
    </div>
</form>