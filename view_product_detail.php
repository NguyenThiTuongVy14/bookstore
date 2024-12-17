<?php
include ('./database/connectdb.php');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $query = "SELECT p.product_id, p.product_title, p.product_description, p.product_image1, p.product_image2, p.product_image3, p.product_price, n.nxb_title 
              FROM products p 
              JOIN nhaxuatban n ON p.nxb_id = n.nxb_id 
              WHERE p.product_id = :product_id";
    $stmt = $con->prepare($query);
    $stmt->bindParam("product_id", $product_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Sản phẩm không tồn tại!";
        exit();
    }
} else {
    echo "Thiếu ID sản phẩm!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            display: flex;
            justify-content: center;
            padding: 20px;
            background-color: #fff;
        }

        .image-gallery {
            flex: 1;
            position: relative;
            margin-right: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .slides img {
            width: 350px;
            height: 350px;
            display: none;
        }

        .slides img.active {
            display: block;
        }

        .prev,
        .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 100;
        }

        .prev {
            left: 10px;
        }

        .next {
            right: 10px;
        }

        .product-details {
            flex: 1;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .price {
            color: red;
            font-size: 24px;
            font-weight: bold;
        }

        .description {
            margin: 20px 0;
            line-height: 1.5;
        }

        .buy-now {
            display: inline-block;
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .back {
            display: inline-block;
            background-color: #17a2b8;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .back:hover{
            background-color: #037587;
        }

        .buy-now:hover {
            background-color: #218838;
        }
        
    </style>
</head>

<body>

    <div class="container">
        <div class="image-gallery">
            <div class="slides">
                <img src="./asset/img/<?php echo $product['product_image1']; ?>" class="active" alt="Image 1">
                <img src="./asset/img/<?php echo $product['product_image2']; ?>" alt="Image 2">
                <img src="./asset/img/<?php echo $product['product_image3']; ?>" alt="Image 3">
            </div>
            <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
            <button class="next" onclick="changeSlide(1)">&#10095;</button>
        </div>

        <div class="product-details">
            <p>Mã sách: <?php echo $product['product_id'] ?></p>
            <h1><?php echo $product['product_title']; ?></h1>
            <p class="price">Giá sách: <?php echo number_format($product['product_price'], 0, ',', '.'); ?> VND</p>
            <p>Nhà xuất bản: <?php echo $product['nxb_title'] ?></p>
            <a href="add_to_cart.php?product_id=<?php echo $product['product_id']; ?>" class="buy-now">Mua ngay</a>
            <a href="index.php" class="back">Sản phẩm khác</a>
            <p class="description"><?php echo $product['product_description']; ?></p>
        </div>
    </div>
    

    <script>
        let currentIndex = 0;
        const slides = document.querySelectorAll('.slides img');

        function changeSlide(direction) {
            slides[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + direction + slides.length) % slides.length;
            slides[currentIndex].classList.add('active');
        }
    </script>

</body>

</html>
