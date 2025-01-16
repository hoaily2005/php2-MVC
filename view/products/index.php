<h1>Product List</h1>
<a href="/products/create" class="btn btn-primary mb-3">Create Product</a>
<a href="/products/add-skus" class="btn btn-primary mb-3">Add SKUs</a>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?= $product['id'] ?></td>
            <td><?= $product['name'] ?></td>
            <td><?= $product['price'] ?></td>
            <td><?= $product['description'] ?></td>
            <td>
                <a href="/products/detail/<?= $product['id'] ?>" class="btn btn-info btn-sm">View</a>
                <a href="/products/edit/<?= $product['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="/products/delete/<?= $product['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    
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

</table>