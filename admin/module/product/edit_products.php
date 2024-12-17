<?php
include("../database/connectdb.php");
if (isset($_GET['edit_products'])) {
    $edit_id = $_GET['edit_products'];
    
    // Truy vấn lấy dữ liệu sản phẩm
    $get_data = "SELECT * FROM `products` WHERE product_id = :edit_id";
    $stmt = $con->prepare($get_data);
    $stmt->bindParam(':edit_id', $edit_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $product_title = $row['product_title'];
    $product_description = $row['product_description'];
    $danhmuc_id = $row['danhmuc_id'];
    $theloai_id = $row['nxb_id'];
    $product_image1 = $row['product_image1'];
    $product_image2 = $row['product_image2'];
    $product_image3 = $row['product_image3'];
    $product_price = $row['product_price'];
}


// Fetching category name
$select_category = "SELECT * FROM `danhmuc` WHERE danhmuc_id = :danhmuc_id";
$stmt_category = $con->prepare($select_category);
$stmt_category->bindParam(':danhmuc_id', $danhmuc_id, PDO::PARAM_INT);
$stmt_category->execute();
$row_category = $stmt_category->fetch(PDO::FETCH_ASSOC);
$danhmuc_title = $row_category['danhmuc_title'];


// Fetching the loai (brands) name
$select_brands = "SELECT * FROM `nhaxuatban` WHERE nxb_id = :theloai_id";
$stmt_brands = $con->prepare($select_brands);
$stmt_brands->bindParam(':theloai_id', $theloai_id, PDO::PARAM_INT);
$stmt_brands->execute();
$row_brands = $stmt_brands->fetch(PDO::FETCH_ASSOC);
$theloai_title = $row_brands['nxb_title'];

?>



<div class="container mt-4">
    <h1 class="text-center text-danger">CHỈNH SỬA SẢN PHẨM</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_title" class="form-label"> Tiêu đề sản phẩm </label>
            <input type="text" name="product_title" value="<?php echo $product_title ?>" class="form-control" required>
        </div>
        <div class="form-outline w-50 m-auto mb-4 mt-2">
            <label for="product_title" class="form-label mt-2"> Mô tả sản phẩm </label>
            <input type="text" name="product_description" value="<?php echo $product_description ?>"
                class="form-control" required>


        </div>
    
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_category" class="form-label mt-2"> Thuộc danh mục? </label>
            <select name="product_category" id="" class="form-select">
                <option value="<?php echo $danhmuc_id ?>">
                    <?php echo $danhmuc_title ?>
                </option>
                <?php
                $select_category_all = "SELECT * FROM `danhmuc`";
                $result_category_all = $con->prepare($select_category_all);
                $result_category_all->execute();
                while($row_category = $result_category_all->fetch(PDO::FETCH_ASSOC)) 
                {
                    $danhmuc_title= $row_category["danhmuc_title"];
                    $danhmuc_id=$row_category['danhmuc_id'];
                    echo "<option value ='$danhmuc_id'>$danhmuc_title</option>";
                }
                ?>
            </select>

        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_brands" class="form-label mt-2"> Thuộc NXB? </label>
            <select name="product_brands" id="" class="form-select">
                <option value="<?php echo $theloai_id ?>">
                    <?php echo $theloai_title ?>
                </option>

                <?php
                $select_brands_all = "SELECT * FROM `nhaxuatban`";
                $result_brands_all = $con->prepare($select_brands_all);
                $result_brands_all->execute();
                while ($row_brands_all = $result_brands_all->fetch(PDO::FETCH_ASSOC)) {
                    $theloai_title = $row_brands_all['nxb_title'];
                    $theloai_id = $row_brands_all['nxb_id'];
                    echo "<option value='$theloai_id'>$theloai_title</option>";
                }

                ?>
            </select>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image1" class="form-label "> Hình 1</label>
            <div class="d-flex">
                <input type="file" name="product_image1" class="form-control w-90 m-auto">
                
                <img src="../asset/img/<?php echo $product_image1 ?>" alt="" class="edit_image" width="100px">

            </div>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image2" class="form-label "> Hình 2</label>
            <div class="d-flex">
                <input type="file" name="product_image2" class="form-control w-90 m-auto">
                <img src="../asset/img/<?php echo $product_image2 ?>" alt="" class="edit_image" width="100px">

            </div>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image3" class="form-label "> Hình 3</label>
            <div class="d-flex">
                <input type="file" name="product_image3" class="form-control w-90 m-auto">
                <img src="../asset/img/<?php echo $product_image3 ?>" alt="" class="edit_image" width="100px">

            </div>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_price" class="form-label "> Giá tiền </label>
            <input type="text" value="<?php echo $product_price ?>" name="product_price" class="form-control " required>
        </div>
        <div class="text-center">
            <input type="submit" name="edit_product" value="Cập nhật" class="btn btn-danger border-0 px-3 py-2 mt-2 ">
        </div>
    </form>
</div>

<!-- cap nhat product thong qua nut cap nhat -->
<?php

if (isset($_POST['edit_product'])) {
    // Lấy dữ liệu từ form
    $product_title = $_POST['product_title'];
    $product_description = $_POST['product_description'];
    
    $product_category = $_POST['product_category'];
    $product_brands = $_POST['product_brands'];
    $product_price = $_POST['product_price'];

    // Kiểm tra các trường bắt buộc
    if (empty($product_title) || empty($product_description) || empty($product_category) || empty($product_brands) || empty($product_price)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin.');</script>";
        exit();
    }

    // Kiểm tra giá sản phẩm có hợp lệ không
    if (!is_numeric($product_price) || $product_price < 0) {
        echo "<script>alert('Giá sản phẩm không hợp lệ');</script>";
        exit();
    }

    // Xử lý ảnh tải lên
    $product_image1 = $_FILES['product_image1']['name'];
    $product_image2 = $_FILES['product_image2']['name'];
    $product_image3 = $_FILES['product_image3']['name'];

    // Kiểm tra và di chuyển ảnh nếu có
    if (!empty($product_image1)) {
        move_uploaded_file($_FILES['product_image1']['tmp_name'], "./product_images/$product_image1");
    } else {
        $product_image1 = $row['product_image1']; 
    }

    if (!empty($product_image2)) {
        move_uploaded_file($_FILES['product_image2']['tmp_name'], "./product_images/$product_image2");
    }
    else{
        $product_image2=$row['product_image2'];
    }
    if (!empty($product_image3)) {
        move_uploaded_file($_FILES['product_image3']['tmp_name'], "./product_images/$product_image3");
    }
    else{
        $product_image3=$row['product_image3'];
    }

    // Cập nhật sản phẩm
    $update_product = "UPDATE `products` SET 
        product_title = :product_title,
        product_description = :product_description,
        danhmuc_id = :product_category,
        nxb_id = :product_brands,
        product_image1 = :product_image1,
        product_image2 =:product_image2,
        product_image3 = :product_image3,
        product_price = :product_price 
        WHERE product_id = :edit_id";

    // Chuẩn bị câu truy vấn
    $stmt =$con->prepare($update_product);

    $stmt->bindParam(":product_price", $product_price);
    $stmt->bindParam(":product_description",$product_description);
    $stmt->bindParam(":product_title",$product_title);
    $stmt->bindParam(":product_category",$product_category);
    $stmt->bindParam(":product_brands",$product_brands);
    $stmt->bindParam("product_image1",$product_image1);
    $stmt->bindParam("product_image2",$product_image2);
    $stmt->bindParam("product_image3",$product_image3);
    $stmt->bindParam(":edit_id",$edit_id,PDO::PARAM_INT);

    // Kiểm tra kết quả
    try {
        $stmt->execute();
        echo "<script>alert('Cập nhật thành công');</script>";
        echo "<script>window.open('./index.php?view_products','_self')</script>"; 
    } catch (Throwable $th) {
        echo "<script>alert('Cập nhật không thành công');</script>";
    }
}

?>