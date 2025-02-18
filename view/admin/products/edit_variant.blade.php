@extends('layouts.admin')
@section('content')
<h1>Edit Variant: <?= htmlspecialchars($variant['sku']) ?></h1>
<form action="/admin/products/variants/edit/<?= $variant['id'] ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="product_id">Product</label>
        <select name="product_id" id="product_id" class="form-control" required>
            <?php foreach ($products as $product): ?>
                <option value="<?= $product['id'] ?>" <?= $product['id'] == $variant['product_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($product['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="color_id">Color</label>
        <select name="color_id" id="color_id" class="form-control" required>
            <?php foreach ($colors as $color): ?>
                <option value="<?= $color['id'] ?>" <?= $color['id'] == $variant['color_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($color['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="size_id">Size</label>
        <select name="size_id" id="size_id" class="form-control" required>
            <?php foreach ($sizes as $size): ?>
                <option value="<?= $size['id'] ?>" <?= $size['id'] == $variant['size_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($size['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" class="form-control" value="<?= $variant['quantity'] ?>" required>
    </div>

    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" name="price" id="price" class="form-control" value="<?= $variant['price'] ?>" required>
    </div>

    <div class="form-group">
        <label for="sku">SKU</label>
        <input type="text" name="sku" id="sku" class="form-control" value="<?= htmlspecialchars($variant['sku']) ?>" required>
    </div>

    <div class="form-group">
        <label for="image">Image</label>
        <?php if (!empty($variant['image'])): ?>
            <div>
                <img src="<?= 'http://localhost:8000/' . $variant['image'] ?>" alt="Variant Image" width="100" class="mb-2">
            </div>
        <?php endif; ?>
        <input type="file" name="image" id="image" class="form-control">
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="form-group">
        <button type="submit" class="btn btn-success">Update Variant</button>
        <a href="/admin/products/show_variant/<?= $variant['product_id'] ?>" class="btn btn-primary mb-3">Back to Product Variants</a>
    </div>
</form>
@endsection