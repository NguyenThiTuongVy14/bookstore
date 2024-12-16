<?php
include("../database/connectdb.php"); 

if (isset($_POST["them_product"])) {

    $product_title = $_POST['product_title'];
    $product_description = $_POST['description'];
    $product_category = $_POST['product_category'];
    $product_brands = $_POST['product_brands'];
    $product_status = '1';
    $product_price = $_POST['product_price'];
    $product_stock = $_POST['product_stock'];

    if (!is_numeric($product_price) || $product_price < 1000) {
        echo "<script>alert('Giá sản phẩm không hợp lệ (>1000)')</script>";
        echo "<script>window.open('index.php?insert_product','_self')</script>";
        exit;
    }

    if (!is_numeric($product_stock) || $product_stock < 0) {
        echo "<script>alert('Sản phẩm kho phải là số và không âm')</script>";
        echo "<script>window.open('index.php?insert_product','_self')</script>";
        exit;
    }

    if (empty($product_description) || strlen($product_description) > 255) {
        echo "<script>alert('Mô tả sản phẩm không được trống và không quá 255 ký tự')</script>";
        echo "<script>window.open('them_sanpham','_self')</script>";
        exit;
    }

    if (empty($product_category)) {
        echo "<script>alert('Vui lòng chọn danh mục sản phẩm');</script>";
        exit;
    }

    $product_image1 = $_FILES['product_image1']['name'];
    $product_image2 = $_FILES['product_image2']['name'];
    $product_image3 = $_FILES['product_image3']['name'];

    $temp_image1 = $_FILES['product_image1']['tmp_name'];
    $temp_image2 = $_FILES['product_image2']['tmp_name'];
    $temp_image3 = $_FILES['product_image3']['tmp_name'];

    if ($product_title == '' || $product_description == '' || $product_brands == '' || $product_price == '' || $product_category == '') {
        echo "<script>alert('Hãy nhập đủ thông tin')</script>";
        echo "<script>window.open('index.php?insert_product','_self')</script>";
    } else {
        move_uploaded_file($temp_image1, "./product_images/$product_image1");
        move_uploaded_file($temp_image2, "./product_images/$product_image2");
        move_uploaded_file($temp_image3, "./product_images/$product_image3");

        $select_query = "SELECT * FROM `products` WHERE product_title = :product_title";
        $stmt = $con->prepare($select_query);
        $stmt->bindParam(':product_title', $product_title, PDO::PARAM_STR);
        $stmt->execute();
        $result_select = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result_select) > 0) {
            echo "<script>alert('Sản phẩm đã có trong hệ thống')</script>";
        } else {
            $product_category = (int) $product_category;
            $insert_products = "INSERT INTO `products` 
            (product_title, product_description, danhmuc_id, nxb_id, product_image1, product_image2, product_image3, product_price, date, status, product_stock) 
            VALUES 
            (:product_title, :product_description, :danhmuc_id, :nxb_id, :product_image1, :product_image2, :product_image3, :product_price, NOW(), :status, :product_stock)";

            $stmt_insert = $con->prepare($insert_products);
            $stmt_insert->bindParam(':product_title', $product_title, PDO::PARAM_STR);
            $stmt_insert->bindParam(':product_description', $product_description, PDO::PARAM_STR);
            $stmt_insert->bindParam(':danhmuc_id', $product_category, PDO::PARAM_INT);
            $stmt_insert->bindParam(':nxb_id', $product_brands, PDO::PARAM_INT);
            $stmt_insert->bindParam(':product_image1', $product_image1, PDO::PARAM_STR);
            $stmt_insert->bindParam(':product_image2', $product_image2, PDO::PARAM_STR);
            $stmt_insert->bindParam(':product_image3', $product_image3, PDO::PARAM_STR);
            $stmt_insert->bindParam(':product_price', $product_price, PDO::PARAM_STR);
            $stmt_insert->bindParam(':status', $product_status, PDO::PARAM_STR);
            $stmt_insert->bindParam(':product_stock', $product_stock, PDO::PARAM_INT);

            $result_insert = $stmt_insert->execute();

            if ($result_insert) {
                echo "THÊM THÀNH CÔNG";
                unset($_SESSION['product_title']);
                unset($_SESSION['product_description']);
                unset($_SESSION['product_category']);
                unset($_SESSION['product_brands']);
                unset($_SESSION['product_price']);
                unset($_SESSION['product_stock']);
                header("Location: ./index.php?view_products");
            } else {
                echo "<script>alert('Thêm không thành công')</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- css file -->
    <!-- <link rel="stylesheet" href="../asset/style.css"> -->
        <link rel="stylesheet" href="style.css">
    <style>
        .admin_img {
            width: 100px;
            object-fit: contain;
        }
    </style>

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>

<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center text-success">THÊM SẢN PHẨM</h1>

        <!-- form -->

        <form action="" method="post" enctype="multipart/form-data">
            <!-- title -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_title" class="form-label">Tên sản phẩm</label>
                <input type="text" name="product_title" id="product_title" class="form-control"
                    placeholder="Thêm tên sản phẩm" autocomplete="off" required="required"
                    value="<?php echo isset($_SESSION['product_title']) ? $_SESSION['product_title'] : ''; ?>">
            </div>

            <!-- description -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="description" class="form-label">Mô tả sản phẩm</label>
                <textarea name="description" id="description" class="form-control" placeholder="Thêm mô tả sản phẩm"
                    rows="4" autocomplete="off" required="required"
                    style="word-wrap: break-word;"><?php echo isset($_SESSION['product_description']) ? $_SESSION['product_description'] : ''; ?></textarea>
            </div>

            <!-- danh mục -->
            <div class="form-outline mb-4 w-50 m-auto">
                <select name="product_category" class="form-select">
                    <option value="">Chọn danh mục</option>
                    <?php
                    $select_query = "SELECT * FROM `danhmuc`";
                    $stmt = $con->prepare($select_query);
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $danhmuc_title = $row['danhmuc_title'];
                        $danhmuc_id = $row['danhmuc_id'];

                        $selected = (isset($_SESSION['product_category']) && $_SESSION['product_category'] == $danhmuc_id) ? 'selected' : '';

                        echo "<option value='$danhmuc_id' $selected>$danhmuc_title</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- brands -->
            <div class="form-outline mb-4 w-50 m-auto">
                <select name="product_brands" id="" class="form-select">
                    <option value="">Chọn nhà xuất bản</option>
                    <?php
                    $select_query = "SELECT * FROM `nhaxuatban`";
                    $stmt = $con->prepare($select_query);
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $theloai_title = $row['nxb_title'];
                        $theloai_id = $row['nxb_id'];

                        $selected = (isset($_SESSION['product_brands']) && $_SESSION['product_brands'] == $theloai_id) ? 'selected' : '';

                        echo "<option value='$theloai_id' $selected>$theloai_title</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Image 1 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image1" class=" form-label">Hình 1</label>
                <input type="file" name="product_image1" id="product_image1" class="form-control">
            </div>

            <!-- Image 2 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image2" class=" form-label">Hình 2</label>
                <input type="file" name="product_image2" id="product_image2" class="form-control">
            </div>

            <!-- Image 3 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image3" class=" form-label">Hình 3</label>
                <input type="file" name="product_image3" id="product_image3" class="form-control">
            </div>

            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_price" class="form-label">Giá tiền</label>
                <input type="text" name="product_price" id="product_price" class="form-control"
                    placeholder="Giá tiền sản phẩm" autocomplete="off" required="required"
                    value="<?php echo isset($_SESSION['product_price']) ? $_SESSION['product_price'] : ''; ?>">
            </div>

            <!-- Sẵn có -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_stock" class="form-label">Sẵn có:</label>
                <input type="text" name="product_stock" id="product_stock" class="form-control"
                    placeholder="Số lượng trong kho" autocomplete="off" required="required"
                    value="<?php echo isset($_SESSION['product_stock']) ? $_SESSION['product_stock'] : ''; ?>">
            </div>

            <!-- button -->
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="them_product" class="btn bg-primary text-light mt-3" value="Thêm sản phẩm">
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <a href="index.php?view_products">Quay về</a>
            </div>
        </form>
    </div>
</body>

</html>