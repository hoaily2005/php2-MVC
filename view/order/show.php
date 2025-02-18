<div class="container mt-5">
    <h1 class="text-center mb-4">Chi Tiết Đơn Hàng #<?php echo $order['id']; ?></h1>

    <div class="card order-detail-card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="http://localhost:8000/<?php echo $order['product_image']; ?>" alt="Ảnh sản phẩm" class="img-fluid product-image">
                </div>
                <div class="col-md-8">
                    <h5 class="card-title product-name"><?php echo $order['product_name']; ?></h5>
                    <div class="order-details">
                        <p><strong>SKU:</strong> <?php echo $order['sku']; ?></p>
                        <p><strong>Kích Cỡ:</strong> <?php echo $order['size_name']; ?></p>
                        <p><strong>Màu Sắc:</strong> <?php echo $order['color_name']; ?></p>
                        <p><strong>Giá:</strong> <?php echo number_format($order['price'], 0, ',', '.'); ?> VND</p>
                        <p><strong>Số Lượng:</strong> <?php echo $order['quantity']; ?></p>
                        <p><strong>Tổng Tiền:</strong> <?php echo number_format($order['total_price'], 0, ',', '.'); ?> VND</p>
                        <p class="payment-status <?php echo strtolower($order['payment_status']); ?>">
                            <strong>Trạng Thái Thanh Toán:</strong> <?php echo $order['payment_status']; ?>
                        </p>
                        <p class="payment-method <?php echo strtolower($order['payment_method']); ?>">
                            <strong>Phương Thức Thanh Toán:</strong> <?php echo $order['payment_method']; ?>
                        </p>
                        <p><strong>Địa Chỉ Giao Hàng:</strong> <?php echo $order['shipping_address']; ?></p>
                        <p><strong>Ngày Tạo:</strong> <?php echo $order['created_at']; ?></p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="/orders" class="btn btn-back">Quay lại danh sách đơn hàng</a>
            </div>
        </div>
    </div>
</div>

<style>
    /* .container {
        max-width: 900px;
        margin: auto;
    } */

    .order-detail-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        background-color: #f8f9fa;
    }

    .card-body {
        padding: 30px;
    }

    .product-image {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .product-name {
        font-size: 1.75rem;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .order-details p {
        font-size: 1rem;
        color: #495057;
        margin-bottom: 10px;
    }

    .payment-status, .payment-method {
        padding: 8px 12px;
        border-radius: 5px;
        display: inline-block;
        font-weight: bold;
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
        background-color: rgb(255, 230, 0);
        color: #000;
    }

    .btn-back {
        background-color: #007bff;
        border: none;
        padding: 10px 25px;
        border-radius: 5px;
        color: #fff;
        text-decoration: none;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    .btn-back:hover {
        background-color: #0056b3;
    }

    .text-center {
        text-align: center;
    }

    .mt-4 {
        margin-top: 1.5rem;
    }
</style>