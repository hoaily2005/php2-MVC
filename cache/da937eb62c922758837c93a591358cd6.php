
<?php $__env->startSection('content'); ?>
<h1>Chỉnh sửa mã giảm giá</h1>

<div class="card">
    <div class="card-body">
        <form action="/admin/coupons/edit/<?= $coupon['id'] ?>" method="POST">
            <div class="mb-3">
                <label for="code" class="form-label">Mã giảm giá</label>
                <input type="text" class="form-control" id="code" name="code" value="<?= htmlspecialchars($coupon['code']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="discount" class="form-label">Giá trị giảm</label>
                <input type="number" class="form-control" id="discount" name="discount" value="<?= $coupon['discount'] ?>" min="0" required>
            </div>

            <div class="mb-3">
                <label for="discount_type" class="form-label">Loại giảm giá</label>
                <select class="form-select" id="discount_type" name="discount_type" required>
                    <option value="fixed" <?= $coupon['discount_type'] === 'fixed' ? 'selected' : '' ?>>Số tiền</option>
                    <option value="percent" <?= $coupon['discount_type'] === 'percent' ? 'selected' : '' ?>>Phần trăm</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="expiry_date" class="form-label">Ngày hết hạn</label>
                <input type="datetime-local" class="form-control" id="expiry_date" name="expiry_date" value="<?= date('Y-m-d\TH:i', strtotime($coupon['expiry_date'])) ?>" required>
            </div>

            <div class="mb-3">
                <label for="usage_limit" class="form-label">Số lượng sử dụng tối đa</label>
                <input type="number" class="form-control" id="usage_limit" name="usage_limit" value="<?= $coupon['usage_limit'] ?>" min="1" required>
            </div>

            <div class="mb-3">
                <label for="is_active" class="form-label">Trạng thái</label>
                <select class="form-select" id="is_active" name="is_active" required>
                    <option value="1" <?= $coupon['is_active'] ? 'selected' : '' ?>>Hoạt động</option>
                    <option value="0" <?= !$coupon['is_active'] ? 'selected' : '' ?>>Không hoạt động</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="/admin/coupons" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\FPT Polytechnic\php2\view/admin/coupons/edit.blade.php ENDPATH**/ ?>