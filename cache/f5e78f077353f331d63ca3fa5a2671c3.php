
<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Danh sách Đơn Hàng</h1>

    <?php if (!empty($orders)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Mã Đơn Hàng</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái </th>
                        <th>Phương Thức </th>
                        <th>Ngày Tạo</th>
                        <th>Chi Tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr class="text-center">
                            <td><?php echo $order['id']; ?></td>
                            <td class="product-info">
                                <div class="product-image">
                                    <img src="http://localhost:8000/<?php echo $order['product_image']; ?>" alt="ảnh sản phẩm">
                                </div>
                                <div class="product-name">
                                    <p><?php echo $order['product_name']; ?></p>
                                </div>
                            </td>
                            <td><?php echo number_format($order['total_price'], 0, ',', '.'); ?> VND</td>
                            <td><span class="payment-status <?php echo strtolower(str_replace(' ', '-', $order['payment_status'])); ?>">
                                    <?php echo $order['payment_status']; ?>
                                </span></td>
                            <td><?php echo $order['payment_method']; ?></td>
                            <td><?php echo $order['created_at']; ?></td>
                            <td><a href="/orders/show/<?php echo $order['id']; ?>" class="btn btn-info btn-sm">Xem Chi Tiết</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center">Không có đơn hàng nào.</p>
    <?php endif; ?>
    
</div>
<style>
    .product-info {
        display: flex;
        align-items: center;
    }

    .product-image {
        width: 100px;
        height: 100px;
        overflow: hidden;
        margin-right: 15px;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-name p {
        margin: 0;
        font-weight: bold;
        font-size: 14px;
        line-height: 1.4;
    }

    .payment-status {
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        color: white;
        text-align: center;
        display: inline-block;
    }

    .payment-status.completed {
        background-color: #28a745;
    }

    .payment-status.failed {
        background-color: #dc3545;
    }

    .payment-status.pending {
        background-color: #ffc107;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\FPT Polytechnic\php2\view/order/list.blade.php ENDPATH**/ ?>