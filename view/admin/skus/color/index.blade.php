@extends('layouts.admin')
@section('content')
<h1>Quản lí màu sắc</h1>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Hành Động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($colors as $color): ?>
        <tr>
            <td><?= $color['id'] ?></td>
            <td><?= $color['name'] ?></td>
            <td>
                <!-- <a href="/color/<?= $color['id'] ?>" class="btn btn-info btn-sm">View</a> -->
                <a href="/admin/colors/edit/<?= $color['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                <a href="/admin/colors/delete/<?= $color['id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
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
@endsection