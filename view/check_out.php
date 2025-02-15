<div class="container mt-5">
    <h2 class="mb-4">Thanh toán</h2>

    <div class="row">
        <!-- Thông tin khách hàng -->
        <div class="col-md-6">
            <form action="/checkout" method="POST">
                <?php 
                $user_id = $_SESSION['users']['id'] ?? null;
                $totalPrice = $_SESSION['cart']['total_price'] ?? 0;
                $totalPrice = 0;
                    foreach ($carts as $cart) {
                        $totalPrice += $cart['price'] * $cart['quantity'];
                    }
                ?>
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <input type="hidden" name="payment_method" value="COD">
                <input type="hidden" name="payment_status" value="Pending">
                <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
                

                <!-- Các thông tin khách hàng -->
                <div class="mb-3">
                    <label class="form-label">Họ và Tên</label>
                    <input type="text" class="form-control" placeholder="Nhập họ và tên" name="name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Nhập email" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" placeholder="Nhập số điện thoại" name="phone" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Địa chỉ giao hàng</label>
                    <textarea class="form-control" rows="3" placeholder="Nhập địa chỉ" name="address" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Đặt Hàng <i class="fa-solid fa-bag-shopping"></i></button>
            </form>


        </div>

        <!-- Phương thức thanh toán -->
        <div class="col-md-6">
            <h4>Phương thức thanh toán</h4>
            <form>
                <div class="form-check d-flex align-items-center">
                    <input class="form-check-input me-2" type="radio" name="paymentMethod" id="cod" checked>
                    <label class="form-check-label d-flex align-items-center" for="cod">
                        <img src="https://cdn-icons-png.flaticon.com/512/2897/2897832.png" alt="COD" width="20" height="20" class="me-2">
                        Thanh toán khi nhận hàng (COD)
                    </label>
                </div>
                <div class="form-check d-flex align-items-center mt-2">
                    <input class="form-check-input me-2" type="radio" name="paymentMethod" id="vnpay">
                    <label class="form-check-label d-flex align-items-center" for="vnpay">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTp1v7T287-ikP1m7dEUbs2n1SbbLEqkMd1ZA&s" alt="VNPay" width="20" height="20" class="me-2">
                        VNPay
                    </label>
                </div>
                <div class="form-check d-flex align-items-center mt-2">
                    <input class="form-check-input me-2" type="radio" name="paymentMethod" id="momo">
                    <label class="form-check-label d-flex align-items-center" for="momo">
                        <img src="https://play-lh.googleusercontent.com/uCtnppeJ9ENYdJaSL5av-ZL1ZM1f3b35u9k8EOEjK3ZdyG509_2osbXGH5qzXVmoFv0" alt="MOMO" width="20" height="20" class="me-2">
                        MOMO
                    </label>
                </div>
            </form>

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

        </div>
    </div>
</div>

<?php
// echo "<pre>";
// var_dump($cart);
// echo "s</pre>";
?>