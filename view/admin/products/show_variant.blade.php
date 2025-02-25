@extends('layouts.admin')
@section('content')
<h1>Chi tiết biến thể <?= $product['name'] ?></h1>

<a href="/admin/products" class="btn btn-primary mb-3">Quay lại trang sản phẩm <i class="fa-solid fa-arrow-left"></i></a>

<div style="overflow-x: auto;">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Màu sắc</th>
                <th>Size</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>SKU</th>
                <th>Hình Ảnh</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($variants as $variant): ?>
                <tr>
                    <td><?= $variant['id'] ?></td>
                    <td><?= $variant['color_name'] ?></td>
                    <td><?= $variant['size_name'] ?></td>
                    <td><?= $variant['quantity'] ?></td>
                    <td><?= $variant['price'] ?></td>
                    <td><?= $variant['sku'] ?></td>
                    <td><img src="http://localhost:8000/<?= $variant['image'] ?>" alt="<?= $variant['sku'] ?>" width="100"></td>
                    <td>
                        <a href="/admin/products/variants/edit/<?= $variant['id'] ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a> |
                        <a href="/admin/products/variants/delete/<?= $variant['id'] ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
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