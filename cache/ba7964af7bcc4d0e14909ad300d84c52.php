
<?php $__env->startSection('content'); ?>
<h1>Thêm kích cỡ</h1>
<form method="POST">
    <div class="mb-3">
        <label for="size" class="form-label">Size</label>
        <input type="text" class="form-control" id="name" name="name">
    </div>
    <button type="submit" class="btn btn-success">Thêm</button>
    <a href="/admin" class="btn btn-danger">Thoát</a>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\FPT Polytechnic\php2\view/admin/skus/size/create.blade.php ENDPATH**/ ?>