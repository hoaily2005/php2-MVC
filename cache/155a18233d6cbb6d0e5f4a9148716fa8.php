
<?php $__env->startSection('content'); ?>
<h1>Quản lí size</h1>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Hành Động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sizes as $size): ?>
        <tr>
            <td><?= $size['id'] ?></td>
            <td><?= $size['name'] ?></td>
            <td>
                <!-- <a href="/size/<?= $size['id'] ?>" class="btn btn-info btn-sm">View</a> -->
                <a href="/admin/sizes/edit/<?= $size['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                <a href="/admin/sizes/delete/<?= $size['id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php if (!empty($_SESSION['success'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '<?= $_SESSION['success']; ?>',
            confirmButtonText: 'OK'
        });
    </script>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\FPT Polytechnic\php2\view/admin/skus/size/index.blade.php ENDPATH**/ ?>