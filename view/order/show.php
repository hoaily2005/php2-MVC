<!-- order/show.php -->
<div class="container mt-5">
    <h1 class="text-center mb-4">Chi Tiết Đơn Hàng #<?php echo $order['id']; ?></h1>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="http://localhost:8000/<?php echo $order['product_image']; ?>" alt="Ảnh sản phẩm" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <h5 class="card-title"><?php echo $order['product_name']; ?></h5>
                    <p><strong>SKU:</strong> <?php echo $order['sku']; ?></p>
                    <p><strong>Kích Cỡ:</strong> <?php echo $order['size_name']; ?></p>
                    <p><strong>Màu Sắc:</strong> <?php echo $order['color_name']; ?></p>
                    <p><strong>Giá:</strong> <?php echo number_format($order['price'], 0, ',', '.'); ?> VND</p>
                    <p><strong>Số Lượng:</strong> <?php echo $order['quantity']; ?></p>
                    <p><strong>Tổng Tiền:</strong> <?php echo number_format($order['total_price'], 0, ',', '.'); ?> VND</p>
                    <p><strong>Trạng Thái Thanh Toán:</strong> <?php echo $order['payment_status']; ?></p>
                    <p><strong>Phương Thức Thanh Toán:</strong> <?php echo $order['payment_method']; ?></p>
                    <p><strong>Địa Chỉ Giao Hàng:</strong> <?php echo $order['shipping_address']; ?></p>
                    <p><strong>Ngày Tạo:</strong> <?php echo $order['created_at']; ?></p>
                    <p><strong>Ngày Cập Nhật:</strong> <?php echo $order['updated_at']; ?></p>
                </div>
            </div>
            <a href="/orders" class="btn btn-primary">Quay lại danh sách đơn hàng</a>
        </div>
    </div>
</div>
