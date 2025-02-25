

<?php $__env->startSection('content'); ?>
<br>
<div class="container-fluid">
    <div class="row">
        <!-- Menu lọc bên trái -->
        <div class="col-md-2">
            <h2 class="my-4" style="color: brown;">Bộ lọc</h2>
            <div class="mb-4">
                <!-- Lọc theo danh mục -->
                <div class="mb-3">
                    <form action="" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Danh mục</label><br>
                            <input type="radio" name="category" value="" <?php echo e(!isset($_GET['category']) ? 'checked' : ''); ?>> Tất cả danh mục<br>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="radio" name="category" value="<?php echo e($category['id']); ?>" <?php echo e(isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'checked' : ''); ?>> <?php echo e($category['name']); ?><br>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    
                        <div class="mb-3">
                            <label class="form-label">Mức giá:</label><br>
                            <input type="radio" name="price" value="" <?php echo e(!isset($_GET['price']) ? 'checked' : ''); ?>> Tất cả mức giá<br>
                            <input type="radio" name="price" value="0-500000" <?php echo e(isset($_GET['price']) && $_GET['price'] == '0-500000' ? 'checked' : ''); ?>> Dưới 500k<br>
                            <input type="radio" name="price" value="500000-1000000" <?php echo e(isset($_GET['price']) && $_GET['price'] == '500000-1000000' ? 'checked' : ''); ?>> 500k - 1Tr<br>
                            <input type="radio" name="price" value="1000000-2000000" <?php echo e(isset($_GET['price']) && $_GET['price'] == '1000000-2000000' ? 'checked' : ''); ?>> 1TR - 2Tr<br>
                            <input type="radio" name="price" value="2000000-" <?php echo e(isset($_GET['price']) && $_GET['price'] == '2000000-' ? 'checked' : ''); ?>> Trên 2TR<br>
                        </div>
                    
                        <input type="submit" value="Lọc" class="btn btn-primary w-100">
                    </form>
                    
                </div>
            </div>
        </div>

        <div class="col-md-10">
            <div class="row" id="productList">
                <?php if(empty($products) || count($products) == 0): ?>
                    <div class="col-12">
                        <p class="text-center">Không có sản phẩm phù hợp với bộ lọc của bạn.</p>
                    </div>
                <?php else: ?>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 mt-3">
                            <div class="card shadow-sm rounded">
                                <img src="<?php echo e(asset($product['image'])); ?>" alt="<?php echo e($product['name']); ?>" class="card-img-top" style="height: 250px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo e($product['name']); ?></h5>
                                    <p class="card-text">Số lượng: <?php echo e($product['quantity']); ?></p>
                                    <p class="card-text text-danger"><strong><?php echo e(number_format($product['price'], 0, ',', '.')); ?> VND</strong></p>
                                    <a href="/products/detail/<?php echo e($product['id']); ?>" class="btn btn-primary btn-sm w-100">Xem Chi Tiết</a>
                                </div>
                            </div>
                        </div>
                        <?php if(($index + 1) % 3 == 0): ?>
                            </div>
                            <div class="row mt-4">
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.container-fluid .col-md-2 {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.container-fluid .col-md-2 h2 {
    font-size: 20px;
    font-weight: bold;
}

input[type="radio"] {
    margin-right: 10px;
}

label {
    margin-right: 20px;
    font-size: 14px;
}

#filterButton {
    background-color: brown;
    border-color: brown;
}

.mb-3 {
    margin-bottom: 15px;
}

.mb-4 {
    margin-bottom: 20px;
}

</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\FPT Polytechnic\php2\view/product.blade.php ENDPATH**/ ?>