@extends('layouts.admin')
@section('content')
<h1>Edit Product</h1>
<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Tên sản phẩm</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Mô tả</label>
        <textarea class="form-control" id="description" name="description" rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Số lượng</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="<?= htmlspecialchars($product['quantity']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Giá</label>
        <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?= htmlspecialchars($product['price']) ?>" required>
    </div>

    <div class="mb-3">
        <label for="category" class="form-label">Danh Mục</label>
        <select class="form-control" id="category" name="category" <?= isset($errors['category']) ? 'class="form-control is-invalid"' : ''; ?>>
            <option value="">Chọn danh mục</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id']; ?>" <?= (isset($_POST['category']) && $_POST['category'] == $category['id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div class="text-danger"><?= $errors['category'] ?? ''; ?></div>
    </div>

    <div class="mb-3">
        <label for="current_image" class="form-label">Ảnh hiện tại</label><br>
        <?php if ($product['image']): ?>
            <img src="http://localhost:8000/<?= htmlspecialchars($product['image']) ?>" alt="Product Image" style="width: 100px;">
        <?php else: ?>
            <p>No image available</p>
        <?php endif; ?>
    </div>

    <!-- Allow new image upload -->
    <div class="mb-3">
        <label for="image" class="form-label">Chọn ảnh mới (Tùy chọn)</label>
        <input type="file" class="form-control" id="image" name="image">
    </div>

    <button type="submit" class="btn btn-warning">Cập nhật</button>
    <a href="/admin/products" class="btn btn-danger">Trở về danh sách</a>
</form>
@endsection