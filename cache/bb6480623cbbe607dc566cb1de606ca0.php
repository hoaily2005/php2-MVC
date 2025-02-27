
<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h2 class="mb-4">Thanh toán</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <form action="/checkout" method="POST">
        <div class="row">
            <div class="col-md-6">
                <h4>Thông tin khách hàng</h4>
                <div class="mb-3">
                    <label class="form-label">Họ và Tên</label>
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" placeholder="Nhập họ và tên">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" placeholder="Nhập email">
                </div>
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="Nhập số điện thoại">
                </div>

                <select class="form-select" name="address_id" id="address_select" onchange="toggleAddressFields()">
                    <option value="">-- Chọn địa chỉ từ danh sách hoặc nhập mới --</option>
                    <?php if (!empty($addresses)): ?>
                        <?php foreach ($addresses as $address): ?>
                            <option value="<?php echo $address['id']; ?>">
                                <?php echo htmlspecialchars($address['full_name'] . ' - ' . $address['phone'] . ' - ' . $address['address']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <div id="manual_address_fields">
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ giao hàng (nếu không chọn sẵn)</label>
                        <textarea class="form-control" name="address" rows="3" placeholder="Nhập địa chỉ"></textarea>
                    </div>
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

                <br>
                
                <!-- Tóm tắt đơn hàng -->
                <hr>
                <div class="mb-3">
                    <div class="d-flex">
                        <input type="text" class="form-control" name="coupon_code" placeholder="Nhập mã giảm giá nếu có" 
                            value="<?= isset($_POST['coupon_code']) ? htmlspecialchars($_POST['coupon_code']) : '' ?>">
                        <button type="submit" class="btn btn-primary ms-2">Áp dụng</button>
                    </div>
                    <?php if(isset($error) && $error): ?>
                        <div class="text-danger"><?php echo e($error); ?></div>
                    <?php endif; ?>
                </div>
                <h4 class="mt-4">Tóm tắt đơn hàng</h4>
                <ul class="list-group mb-3">
                    <?php if(!empty($carts)): ?>
                        <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $subTotal = $cart['price'] * $cart['quantity'];
                            ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <img src="http://localhost:8000/<?php echo e($cart['image']); ?>" alt="" class="img-fluid" style="width: 50px;">
                                <span><?php echo e($cart['name']); ?></span>
                                <strong><?php echo e(number_format($subTotal, 0, ',', '.')); ?>₫</strong>
                                <span>Sl: <?php echo e($cart['quantity']); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Tổng cộng</strong>
                            <strong><?php echo e(number_format($totalPrice, 0, ',', '.')); ?>₫</strong>
                        </li>
                        <?php if(isset($discount) && $discount > 0): ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Giảm giá</strong>
                                <strong>-<?php echo e(number_format($discount, 0, ',', '.')); ?>₫</strong>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Giỏ hàng trống</span>
                            <strong>0₫</strong>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <button type="submit" class="btn btn-success w-100">Đặt hàng <i class="fa-solid fa-bag-shopping"></i></button>
        </div>
    </form>
</div>

<script>
function toggleAddressFields() {
    const select = document.getElementById('address_select');
    const manualFields = document.getElementById('manual_address_fields');
    if (select.value === '') {
        manualFields.style.display = 'block';
    } else {
        manualFields.style.display = 'none';
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\FPT Polytechnic\php2\view/checkout/check_out.blade.php ENDPATH**/ ?>