<h1>Đây là trang chủ</h1>

<div class="container">
    <div class="row">
        <?php foreach ($products as $index => $product): ?>
            <div class="col-md-4 mt-3"> 
                <div class="card">
                    <div class="card-body">
                        <h3><?= $product['name'] ?></h3>
                        <p><?= $product['description'] ?></p>
                        <p><?= $product['price'] ?></p>
                        <a href="/products/detail/<?= $product['id'] ?>" class="btn btn-info btn-sm">View</a>
                    </div>
                </div>
            </div>
            <?php if (($index + 1) % 3 == 0): ?>
                </div><div class="row">
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>


<?php if (isset($_SESSION['login_success'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Đăng nhập thành công!',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    <?php unset($_SESSION['login_success']); ?>
<?php endif; ?>