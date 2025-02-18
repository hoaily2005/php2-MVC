
<?php $__env->startSection('content'); ?>
<h1>Create Product Variants</h1>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="product_id" value="<?= isset($product_id) ? $product_id : ''; ?>">

    <div class="mb-3">
        <label for="color_id" class="form-label">Color</label>
        <select name="color_id" id="color_id" class="form-control">
            <?php foreach ($colors as $color): ?>
                <option value="<?= $color['id'] ?>" <?= isset($errors['color_id']) ? 'is-invalid' : ''; ?>><?= $color['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['color_id'])): ?>
            <div class="text-danger"><?= $errors['color_id']; ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="size_id" class="form-label">Size</label>
        <select name="size_id" id="size_id" class="form-control">
            <?php foreach ($sizes as $size): ?>
                <option value="<?= $size['id'] ?>" <?= isset($errors['size_id']) ? 'is-invalid' : ''; ?>><?= $size['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['size_id'])): ?>
            <div class="text-danger"><?= $errors['size_id']; ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="quantity" class="form-label">Số lượng</label>
        <input type="text" class="form-control" id="quantity" name="quantity">
        <?php if (isset($errors['quantity'])): ?>
            <div class="text-danger"><?= $errors['quantity']; ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Giá</label>
        <input type="text" class="form-control" id="price" name="price">
        <?php if (isset($errors['price'])): ?>
            <div class="text-danger"><?= $errors['price']; ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Hình ảnh</label>
        <input type="file" class="form-control" id="image" name="image">
        <?php if (isset($errors['image'])): ?>
            <div class="text-danger"><?= $errors['image']; ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="sku" class="form-label">SKU</label>
        <input type="text" class="form-control" id="sku" name="sku">
        <?php if (isset($errors['sku'])): ?>
            <div class="text-danger"><?= $errors['sku']; ?></div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-success">Create</button>
    <a href="/admin/products" class="btn btn-danger">Back to list</a>
</form>

<?php if (isset($_SESSION['swal'])): ?>
    <script>
        Swal.fire({
            icon: "<?= $_SESSION['swal']['type'] ?>",
            title: "Thông báo",
            text: "<?= $_SESSION['swal']['message'] ?>",
            confirmButtonText: "OK"
        });
    </script>
    <?php unset($_SESSION['swal']); ?>
<?php endif; ?>

<script>
    function generateSku() {
        const randSku = 'SKU' + Math.floor(Math.random() * 1000000);
        const skuInput = document.getElementById('sku');
        skuInput.value = randSku;
    }

    document.addEventListener('DOMContentLoaded', function() {
        generateSku();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\FPT Polytechnic\php2\view/admin/products/variants.blade.php ENDPATH**/ ?>