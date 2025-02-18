
<?php $__env->startSection('content'); ?>
<h1>Edit Role</h1>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label for="role" class="form-label">Change Role</label>
        <select class="form-control" id="role" name="role">
            <option value="user" <?= ($user['role'] === 'user') ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= ($user['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
        </select>
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\FPT Polytechnic\php2\view/admin/user/edit.blade.php ENDPATH**/ ?>