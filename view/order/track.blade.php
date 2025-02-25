<form method="POST" action="/track-order">
    <input type="text" name="tracking_code" placeholder="Nhập mã đơn hàng" required>
    <button type="submit">Theo dõi</button>
</form>

@if (isset($order))
    <div>
        <h3>Chi tiết đơn hàng</h3>
        <p>Mã đơn hàng: {{ $order['tracking_code'] }}</p>
        <p>Trạng thái: {{ $order['payment_status'] }}</p>
        <p>Địa chỉ giao hàng: {{ $order['shipping_address'] }}</p>
        <p>Tổng tiền: {{ number_format($order['total_price'], 0, ',', '.') }}₫</p>
    </div>
@endif
