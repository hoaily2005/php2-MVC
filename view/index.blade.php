@extends('layouts.master')
@section('content')

<div class="p-5 mb-4 bg-image rounded-3" style="background-image: url('https://theme.hstatic.net/200000174405/1001111911/14/slideshow_3.jpg?v=1830'); background-size: cover; background-position: top-center;">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold text-white">Shopdothethao <span class="fs-3">Shop bán đồ thể thao</span></h1>
        <p class="col-md-8 fs-4 text-white" id="text-container"></p>
        <button class="btn btn-light btn-lg text-danger" type="button">Mua ngay!</button>
    </div>
</div>

<div class="container">
    <h2 class="my-5" style="color:brown;">| Danh sách sản phẩm</h2>
    <div class="row">
        <?php foreach ($products as $index => $product): ?>
            <div class="col-md-3 mt-3"> 
                <div class="card shadow-sm rounded">
                    <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="card-img-top" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 16px;"><?= $product['name'] ?></h5>
                        <!-- <p class="card-text text-muted"><?= $product['description'] ?></p> -->
                        <p class="card-text">Số lượng: <?= $product['quantity'] ?></p>
                        <p class="card-text text-danger"><strong><?= number_format($product['price'], 0, ',', '.') ?> VND</strong></p>
                        <a href="/products/detail/<?= $product['id'] ?>" class="btn btn-primary btn-sm w-100">XEM NGAY</a>
                    </div>
                </div>
            </div>
            <?php if (($index + 1) % 4 == 0): ?> 
                </div>
                <div class="row mt-4">
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>


<?php if (isset($_SESSION['login_success'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Đăng nhập thành công!',
            text: 'Chào mừng bạn đến với cửa hàng!',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    <?php unset($_SESSION['login_success']); ?>
<?php endif; ?>
@endsection
