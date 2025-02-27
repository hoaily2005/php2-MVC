@extends('layouts.admin') <!-- Giả định bạn có layout admin -->

@section('content')
<h1>Thêm Mã Giảm Giá</h1>

<form method="POST" action="/admin/coupons/create">
    <div class="mb-3">
        <label for="code" class="form-label">Mã giảm giá</label>
        <input type="text" class="form-control" id="code" name="code" value="<?= htmlspecialchars($_POST['code'] ?? '') ?>" <?= isset($errors['code']) ? 'is-invalid' : ''; ?>>
        <div class="text-danger"><?= $errors['code'] ?? ''; ?></div>
    </div>

    <div class="mb-3">
        <label for="discount" class="form-label">Giá trị giảm</label>
        <input type="number" class="form-control" id="discount" name="discount" value="<?= htmlspecialchars($_POST['discount'] ?? '') ?>" min="1" <?= isset($errors['discount']) ? 'is-invalid' : ''; ?>>
        <div class="text-danger"><?= $errors['discount'] ?? ''; ?></div>
    </div>

    <div class="mb-3">
        <label for="discount_type" class="form-label">Loại giảm giá</label>
        <select class="form-control" id="discount_type" name="discount_type" <?= isset($errors['discount_type']) ? 'class="form-control is-invalid"' : ''; ?>>
            <option value="fixed" <?= (isset($_POST['discount_type']) && $_POST['discount_type'] == 'fixed') ? 'selected' : ''; ?>>Số tiền (VNĐ)</option>
            <option value="percent" <?= (isset($_POST['discount_type']) && $_POST['discount_type'] == 'percent') ? 'selected' : ''; ?>>Phần trăm (%)</option>
        </select>
        <div class="text-danger"><?= $errors['discount_type'] ?? ''; ?></div>
    </div>
    
    <div class="mb-3">
        <label for="usage_limit" class="form-label">Giới hạn sử dụng</label>
        <input type="number" class="form-control" id="usage_limit" name="usage_limit" value="<?= htmlspecialchars($_POST['usage_limit'] ?? '') ?>" min="1" required>
        <div class="text-danger"><?= $errors['usage_limit'] ?? ''; ?></div>
    </div>
    
    <div class="mb-3">
        <label for="expiry_date" class="form-label">Ngày hết hạn</label>
        <input type="datetime-local" class="form-control" id="expiry_date" name="expiry_date" value="<?= htmlspecialchars($_POST['expiry_date'] ?? '') ?>" <?= isset($errors['expiry_date']) ? 'is-invalid' : ''; ?>>
        <div class="text-danger"><?= $errors['expiry_date'] ?? ''; ?></div>
    </div>

    <button type="submit" class="btn btn-success">Thêm mã</button>
    <a href="/admin/coupons" class="btn btn-danger">Quay lại danh sách</a>
</form>

@endsection
