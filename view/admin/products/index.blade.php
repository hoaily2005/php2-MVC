
@extends('layouts.admin')
@section('content')
<h1>Quản lí sản phẩm</h1>
<div style="overflow-x: auto;">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr class = "text center">
                <th>ID</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Hình Ảnh</th>
                <th>Biến Thể</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr class = "align-middle text center">
                    <td><?= $product['id'] ?></td>
                    <td><?= $product['name'] ?></td>
                    <td><?= number_format($product['price'], 0, ',', '.') ?>₫</td>
                    <!-- <td><?= $product['description'] ?></td> -->
                    <td><img src="http://localhost:8000/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="100"></td>
                    <td>
                        <a href="/admin/products/show_variant/<?= $product['id'] ?>" class="btn btn-info btn-sm"><i class="fa-solid fa-eye"></i> Xem biến thể</a>
                    </td>
                    <td>
                        <a href="/admin/products/variants/create/<?= $product['id'] ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Thêm biến thể</a> |
                        <a href="/admin/products/edit/<?= $product['id'] ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a> |
                        <a href="/admin/products/delete/<?= $product['id'] ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
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
@endsection