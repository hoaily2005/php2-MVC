<!-- order_success.php -->
<div class="container mt-5">
    <h2 class="mb-4">Đặt Hàng Thành Công</h2>

    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Cảm ơn bạn!</h4>
        <p>Đơn hàng của bạn đã được tạo thành công. Chúng tôi sẽ xử lý đơn hàng và thông báo cho bạn sớm nhất có thể.</p>
        <hr>
        <p class="mb-0">Số đơn hàng: <?php echo $order_id; ?>. Tổng giá trị đơn hàng: <?php echo number_format($total_price, 0, ',', '.'); ?>₫</p>
    </div>

    <div class="mt-3">
        <a href="/" class="btn btn-primary">Quay lại Trang Chủ</a>
        <a href="/orders" class="btn btn-secondary">Xem Đơn Hàng</a>
    </div>
</div>
