<?php
$search_term = isset($_POST['search']) ? $_POST['search'] : '';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$products_per_page = 6;
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

?>

<div class="row justify-content-center px-1 mt-5">
    <div class="col-md-10">
        <div class="row" id="product-list">
            <?php
                getProducts($page, $products_per_page, $category_id,$search_term); 
            ?>
        </div>
    </div>
</div>

<?php
    generatePagination($con, $page, $products_per_page, $category_id, $search_term);
?>