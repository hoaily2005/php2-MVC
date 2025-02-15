<h1>Quản lí sản phẩm</h1>
<div style="overflow-x: auto;">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
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
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['price'] ?></td>
                    <!-- <td><?= $product['description'] ?></td> -->
                    <td><img src="http://localhost:8000/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="100"></td>
                    <td>
                        <a href="/admin/products/show_variant/<?= $product['id'] ?>" class="btn btn-info btn-sm">View Variant</a>
                    </td>
                    <td>
                        <a href="/admin/products/variants/create/<?= $product['id'] ?>" class="btn btn-primary btn-sm">Add Variants</a>
                        <a href="/admin/products/edit/<?= $product['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="/admin/products/delete/<?= $product['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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