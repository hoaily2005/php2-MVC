@extends('layouts.admin')
@section('content')
<h1>Quản lí danh mục</h1>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
        <tr>
            <td><?= $category['id'] ?></td>
            <td><?= $category['name'] ?></td>
            <td><?= $category['description'] ?></td>
            <td>
                <!-- <a href="/category/<?= $category['id'] ?>" class="btn btn-info btn-sm">View</a> -->
                <a href="/admin/category/edit/<?= $category['id'] ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a> |
                <a href="/admin/category/delete/<?= $category['id'] ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
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