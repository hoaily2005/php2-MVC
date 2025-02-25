
<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <!-- Form để nhập mã đơn hàng -->
    <form action="/tracking" method="GET" class="d-flex justify-content-center mb-5">
        <div class="d-flex align-items-center">
            <label for="order_id" class="form-label me-3 w-100">Nhập mã đơn hàng:</label>
            <input type="text" id="order_id" name="order_id" placeholder="Mã đơn hàng" class="form-control me-3" required>
            <button type="submit" class="btn btn-primary w-50">Tra cứu</button>
        </div>
    </form>

    <?php if(isset($order)): ?>
    <div class="card border-info shadow-lg rounded-lg">
        <div class="card-body">
            <h3 class="card-title text-center text-info mb-4">Thông tin tra cứu đơn hàng #<?php echo e($order['id']); ?></h3>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <img src="http://localhost:8000/<?php echo e($order['product_image']); ?>" alt="Ảnh sản phẩm" class="img-fluid rounded shadow-sm">
                </div>

                <div class="col-md-8">
                    <div class="order-info">
                        <h4 class="product-name text-primary"><?php echo e($order['product_name']); ?></h4>
                        <p><strong>SKU:</strong> <?php echo e($order['sku']); ?></p>
                        <p><strong>Kích Cỡ:</strong> <?php echo e($order['size_name']); ?></p>
                        <p><strong>Màu Sắc:</strong> <?php echo e($order['color_name']); ?></p>
                        <p><strong>Giá:</strong> <?php echo e(number_format($order['price'], 0, ',', '.')); ?> VND</p>
                        <p><strong>Số Lượng:</strong> <?php echo e($order['quantity']); ?></p>
                        <p><strong>Tổng Tiền:</strong> <?php echo e(number_format($order['total_price'], 0, ',', '.')); ?> VND</p>
                        
                        <div class="payment-status-container mb-4">
                            <p class="payment-status <?php echo e(strtolower($order['payment_status'])); ?>"><strong>Trạng Thái Thanh Toán:</strong> <?php echo e($order['payment_status']); ?></p>
                        </div>

                        <p class="payment-method <?php echo e(strtolower($order['payment_method'])); ?>"><strong>Phương Thức Thanh Toán:</strong> <?php echo e($order['payment_method']); ?></p>
                        <p><strong>Địa Chỉ Giao Hàng:</strong> <?php echo e($order['shipping_address']); ?></p>
                        <p><strong>Ngày Tạo:</strong> <?php echo e($order['created_at']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <p class="text-center text-danger">Không tìm thấy đơn hàng.</p>
    <?php endif; ?>
</div>

<style>
    .card {
        background-color: #f1f8ff;
        border-radius: 15px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .product-name {
        font-size: 1.7rem;
        color: #2c3e50;
        font-weight: bold;
    }

    .order-info p {
        font-size: 1rem;
        color: #495057;
        margin-bottom: 8px;
    }

    .payment-status, .payment-method {
        padding: 8px 12px;
        border-radius: 5px;
        font-weight: bold;
        display: inline-block;
    }

    .payment-status.completed {
        background-color: #28a745;
        color: #fff;
    }

    .payment-status.failed {
        background-color: #dc3545;
        color: #fff;
    }

    .payment-status.pending {
        background-color: #ffc107;
        color: #000;
    }

    .payment-method.cod {
        background-color: #28a745;
        color: #fff;
    }

    .payment-method.vnpay {
        background-color: #dc3545;
        color: #fff;
    }

    .payment-method.momo {
        background-color: #ff9800;
        color: #fff;
    }

    .btn-outline-info {
        background-color: transparent;
        color: #17a2b8;
        border: 2px solid #17a2b8;
        padding: 10px 25px;
        border-radius: 5px;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    .btn-outline-info:hover {
        background-color: #17a2b8;
        color: #fff;
    }

    .text-center {
        text-align: center;
    }

    .product-image {
        max-height: 250px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .order-info {
        background-color: #ffffff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .row {
        display: flex;
        justify-content: space-between;
    }

    .col-md-4, .col-md-8 {
        padding: 10px;
    }

 
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\FPT Polytechnic\php2\view//tracking.blade.php ENDPATH**/ ?>