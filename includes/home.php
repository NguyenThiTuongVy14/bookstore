<!-- Main Content -->
<div class="row justify-content-center px-1 mt-5">
    <div class="col-md-10">
        <div class="row justify-content-center" id="product-list">
            <?php getProducts(); ?>
        </div>
    </div>
    <div class="pagination-wrapper mt-3 mb-3">
        <div class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <div class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>">Trang trước</a>
                </div>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <div class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </div>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <div class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">Trang sau</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>