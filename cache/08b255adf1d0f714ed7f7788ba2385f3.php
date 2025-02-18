
<?php $__env->startSection('content'); ?>
<h1>Create Color</h1>
<form method="POST">
    <div class="mb-3">
        <label for="color" class="form-label">Color</label>
        <input type="text" class="form-control" id="name" name="name">
    </div>
    <button type="submit" class="btn btn-success">Create</button>
    <a href="/admin" class="btn btn-danger">Back to list</a>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\FPT Polytechnic\php2\view/admin/skus/color/create.blade.php ENDPATH**/ ?>