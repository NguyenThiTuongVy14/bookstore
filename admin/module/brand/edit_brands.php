<?php 
if(isset($_GET['edit_brands'])){
    $nxb_id=$_GET['edit_brands'];
    $getAll_nxb_query="SELECT * FROM `nhaxuatban` WHERE `nxb_id` = :nxb_id";
    $stmt=$con->prepare($getAll_nxb_query);
    $stmt->bindParam(":nxb_id",$nxb_id);
    $stmt->execute();
    $result=$stmt->fetch(PDO::FETCH_ASSOC);

    if($result){
        $nxb_name=$result['nxb_title'];
    
    }
    else{
        echo "Nhà xuất bản không tồn tại!";
        exit;
    }
}
if(isset($_POST["btnUpdate"])){
    $nxb_id=$_POST['nxb_id'];
    $nxb_name=$_POST['nxb_title'];

    if (!empty($nxb_name)) {
        $update_nxb_query= "UPDATE `nhaxuatban` SET nxb_title = :nxb_title WHERE nxb_id = :nxb_id";
        $stmt=$con->prepare($update_nxb_query);
        $stmt->bindParam(":nxb_id",$nxb_id);
        $stmt->bindParam(":nxb_title",$nxb_name);

        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Nhà xuất bản đã được cập nhật!',
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.href = 'index.php?view_brands';
                    });
                  </script>";
        }else{
            echo "<script>Swal.fire('Lỗi!', 'Có lỗi xảy ra, không thể cập nhật nhà sản xuất.', 'error');</script>";
        }
    }else{
        echo "<script>Swal.fire('Lỗi!', 'Tên nhà sản xuất không được để trống!', 'error');</script>";

    }
}

?>

<h2 class="text-center">Chỉnh sửa Nhà xuất bản</h2>
<form method="post" action="" class="mb-2">
    <div class="input-group w-90 mb-2" >
        <span class="input-group-text bg-primary" id="basic-addon1"><i class="fa-solid fa-receipt"style="color: #c3c3c3;"></i></span>
        <input type="text" name="nxb_title" id="nxb_title" class="form-control" value="<?php echo htmlspecialchars($nxb_name); ?>" required>
    </div>
    <div class="input-group w-10 mb-2 m-auto">
         <input type="hidden" name="nxb_id" value="<?php echo $nxb_id; ?>">
         <input type="submit" class="btn bg-primary text-light border-0 p-2 my-3" name="btnUpdate" value="Cập nhật">
    </div>
  
</form>
