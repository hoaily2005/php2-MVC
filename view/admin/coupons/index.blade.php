@extends('layouts.admin') <!-- Giả định bạn có layout admin -->
@section('content')
<h1>Quản lí mã giảm giá</h1>

<div style="overflow-x: auto;">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th>ID</th>
                <th>Mã giảm giá</th>
                <th>Giá trị giảm</th>
                <th>Loại</th>
                <th>Ngày hết hạn</th>
                <th>Số lượng</th>
                <th>Số lần đã dùng</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($coupons as $coupon): ?>
                <tr class="align-middle text-center">
                    <td><?= $coupon['id'] ?></td>
                    <td><?= htmlspecialchars($coupon['code']) ?></td>
                    <td>
                        <?= number_format($coupon['discount'], 0, ',', '.') . ($coupon['discount_type'] === 'percent' ? '%' : '₫') ?>
                    </td>
                    <td><?= $coupon['discount_type'] === 'fixed' ? 'Số tiền' : 'Phần trăm' ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($coupon['expiry_date'])) ?></td>
                    <td><?= $coupon['usage_limit'] ?></td>
                    <td><?= $coupon['used_count'] ?></td>
                    <td><?= $coupon['is_active'] ? 'Hoạt động' : 'Không hoạt động' ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($coupon['created_at'])) ?></td>
                    <td>
                        <a href="/admin/coupons/edit/<?= $coupon['id'] ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa</a> |
                        <a href="/admin/coupons/delete/<?= $coupon['id'] ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (isset($_SESSION['swal'])): ?>
    <script>
        Swal.fire({
            icon: "<?= $_SESSION['swal']['type'] ?>",
            title: "Thông báo",
            text: "<?= $_SESSION['swal']['message'] ?>",
            confirmButtonText: "OK"
        });
    </script>
    <?php unset($_SESSION['swal']); ?>
<?php endif; ?>

@endsection
