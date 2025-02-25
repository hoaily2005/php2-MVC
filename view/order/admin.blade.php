@extends('layouts.admin')
@section('content')
<h1>Danh sách Đơn Hàng</h1>
<div class="container mt-5">
    <?php if (!empty($orders)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>#ID</th>
                        <th>Sản Phẩm</th>
                        <th>Giá</th>
                        <th>Số Lượng</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Ngày Tạo</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr class="text-center">
                            <td><?php echo $order['order_id']; ?></td>
                            <td style="display: flex; align-items: center;">
                                <img src="http://localhost:8000/<?php echo $order['product_image']; ?>" alt="Ảnh sản phẩm" style="width: 100px; height: auto; margin-right: 10px;">
                                <p style="margin: 0;"><?php echo $order['product_name']; ?></p>
                            </td>
                            <td><?php echo number_format($order['price'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td><?php echo number_format($order['item_total_price'], 0, ',', '.'); ?> VND</td>
                            <td>
                                <form action="/admin/orders/update/<?php echo $order['order_id']; ?>" method="POST" style="display: flex; align-items: center;">
                                    <select name="payment_status" class="form-control form-control-sm" style="margin-right: 10px;">
                                        <option value="completed" <?php echo ($order['payment_status'] == 'completed') ? 'selected' : ''; ?>>Đã thanh toán</option>
                                        <option value="pending" <?php echo ($order['payment_status'] == 'pending') ? 'selected' : ''; ?>>Đang xử lý</option>
                                        <option value="failed" <?php echo ($order['payment_status'] == 'failed') ? 'selected' : ''; ?>>Thất bại</option>
                                    </select>
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fa-solid fa-check"></i></button>
                                </form>
                            </td>
                            <td><?php echo $order['created_at']; ?></td>
                            <td>
                                <form action="/admin/orders/delete/<?php echo $order['order_id']; ?>" method="POST" class="mt-2">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center">Không có đơn hàng nào.</p>
    <?php endif; ?>
</div>
<?php if (!empty($_SESSION['success'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '<?= $_SESSION['success']; ?>',
            confirmButtonText: 'OK'
        });
    </script>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
@endsection
