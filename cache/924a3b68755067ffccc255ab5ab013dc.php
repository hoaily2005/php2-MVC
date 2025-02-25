
<?php $__env->startSection('content'); ?>
<h1>Edit size</h1>
<form method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $size['name'] ?>">
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\FPT Polytechnic\php2\view/admin/skus/size/edit.blade.php ENDPATH**/ ?>