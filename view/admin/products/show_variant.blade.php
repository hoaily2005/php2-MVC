@extends('layouts.admin')
@section('content')
<h1>Variants of Product: <?= $product['name'] ?></h1>

<a href="/admin/products" class="btn btn-primary mb-3">Back to Product List</a>

<div style="overflow-x: auto;">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Color</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>SKU</th>
                <th>Image</th>
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
                        <a href="/admin/products/variants/edit/<?= $variant['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="/admin/products/variants/delete/<?= $variant['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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