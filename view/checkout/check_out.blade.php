@extends('layouts.master')
@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Thanh toán</h2>
    <form action="/checkout" method="POST">
        <div class="row">
            <div class="col-md-6">
                <h4>Thông tin khách hàng</h4>
                <div class="mb-3">
                    <label class="form-label">Họ và Tên</label>
                    <input type="text" class="form-control" name="name" placeholder="Nhập họ và tên">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Nhập email">
                </div>
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại">
                </div>
                <div class="mb-3">
                    <label class="form-label">Địa chỉ giao hàng</label>
                    <textarea class="form-control" name="address" rows="3" placeholder="Nhập địa chỉ"></textarea>
                </div>
            </div>

            <!-- Phương thức thanh toán -->
            <div class="col-md-6">
                <h4>Phương thức thanh toán</h4>
                <div class="form-check d-flex align-items-center">
                    <input class="form-check-input me-2" type="radio" name="payment_method" id="cod" value="cod" checked>
                    <label class="form-check-label d-flex align-items-center" for="cod">
                        <img src="https://cdn-icons-png.flaticon.com/512/2897/2897832.png" alt="COD" width="20" height="20" class="me-2">
                        Thanh toán khi nhận hàng (COD)
                    </label>
                </div>
                <div class="form-check d-flex align-items-center mt-2">
                    <input class="form-check-input me-2" type="radio" name="payment_method" id="vnpay" value="vnpay">
                    <label class="form-check-label d-flex align-items-center" for="vnpay">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTp1v7T287-ikP1m7dEUbs2n1SbbLEqkMd1ZA&s" alt="VNPay" width="20" height="20" class="me-2">
                        VNPay
                    </label>
                </div>
                <div class="form-check d-flex align-items-center mt-2">
                    <input class="form-check-input me-2" type="radio" name="payment_method" id="momo" value="momo">
                    <label class="form-check-label d-flex align-items-center" for="momo">
                        <img src="https://play-lh.googleusercontent.com/uCtnppeJ9ENYdJaSL5av-ZL1ZM1f3b35u9k8EOEjK3ZdyG509_2osbXGH5qzXVmoFv0" alt="MOMO" width="20" height="20" class="me-2">
                        MOMO
                    </label>
                </div>

            <!-- Tóm tắt đơn hàng -->
             <hr>
            <h4 class="mt-4">Tóm tắt đơn hàng</h4>
            <ul class="list-group mb-3">
                <?php if (!empty($carts)): ?>
                    <?php foreach ($carts as $cart): ?>
                        <?php
                        $subTotal = $cart['price'] * $cart['quantity'];
                        ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <img src="http://localhost:8000/<?php echo $cart['image']; ?>" alt="" class="img-fluid" style="width: 50px;">
                            <span><?= $cart['name'] ?></span>
                            <strong><?= number_format($subTotal, 0, ',', '.') ?>₫</strong>
                            <span>Sl: <?= $cart['quantity'] ?></strong>
                        </li>
                    <?php endforeach; ?>
                    <?php
                    $totalPrice = 0;
                    foreach ($carts as $cart) {
                        $totalPrice += $cart['price'] * $cart['quantity'];
                    }
                    ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Tổng cộng</strong>
                        <strong><?= number_format($totalPrice, 0, ',', '.') ?>₫</strong>
                    </li>
                <?php else: ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Giỏ hàng trống</span>
                        <strong>0₫</strong>
                    </li>
                <?php endif; ?>
            </ul>
            <button type="submit" class="btn btn-success w-100">Đặt hàng <i class="fa-solid fa-bag-shopping"></i></button>

        </div>
    </div>
    </form>
</div>

<?php
// echo "<pre>";
// var_dump($cart);
// echo "s</pre>";
?>
@endsection
