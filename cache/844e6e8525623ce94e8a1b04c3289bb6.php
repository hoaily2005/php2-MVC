
<?php $__env->startSection('content'); ?>
<h1>Create Product</h1>
<form method="POST" action="/admin/products/create" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Tên sản phẩm</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" <?= isset($errors['name']) ? 'is-invalid' : ''; ?>>
        <div class="text-danger"><?= $errors['name'] ?? ''; ?></div>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Mô tả</label>
        <textarea class="form-control" id="description" name="description" rows="4" <?= isset($errors['description']) ? 'is-invalid' : ''; ?>><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        <div class="text-danger"><?= $errors['description'] ?? ''; ?></div>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Giá</label>
        <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" <?= isset($errors['price']) ? 'is-invalid' : ''; ?>>
        <div class="text-danger"><?= $errors['price'] ?? ''; ?></div>
    </div>
    
    <div class="mb-3">
        <label for="quantity" class="form-label">Số lượng</label>
        <input type="number" class="form-control" id="quantity" name="quantity" step="0.01" value="<?= htmlspecialchars($_POST['quantity'] ?? '') ?>" <?= isset($errors['quantity']) ? 'is-invalid' : ''; ?>>
        <div class="text-danger"><?= $errors['quantity'] ?? ''; ?></div>
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
        <label for="images" class="form-label">Ảnh Sản Phẩm</label>
        <input type="file" class="form-control" id="images" name="images[]" multiple onchange="previewImages()">
        <div class="text-danger"><?= $errors['images'] ?? ''; ?></div>
    </div>

    <div id="imagePreview" class="mb-3">
    </div>

    <!-- <div class="mb-3">
        <label for="main_image" class="form-label">Select Main Image</label>
        <select class="form-control" id="main_image" name="main_image">
            <?php if (isset($imageUrls) && !empty($imageUrls)): ?>
                <?php foreach ($imageUrls as $index => $imageUrl): ?>
                    <option value="<?= $index ?>"><?= basename($imageUrl) ?></option>
                <?php endforeach; ?>
            <?php else: ?>
                <option>No images uploaded</option>
            <?php endif; ?>
        </select>
    </div> -->

    <button type="submit" class="btn btn-success">Create</button>
    <a href="/admin/products" class="btn btn-danger">Back to list</a>
</form>

<script>
let selectedFiles = []; 

function previewImages() {
    const files = document.getElementById('images').files;
    const previewContainer = document.getElementById('imagePreview');
    previewContainer.innerHTML = '';  
    selectedFiles = Array.from(files); 

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = function (e) {
            const imgContainer = document.createElement('div');
            imgContainer.style.display = 'inline-block';
            imgContainer.style.position = 'relative';
            imgContainer.style.marginRight = '10px';
            imgContainer.style.marginBottom = '10px';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '100px';

            const closeBtn = document.createElement('span');
            closeBtn.innerHTML = 'X';
            closeBtn.style.position = 'absolute';
            closeBtn.style.top = '0';
            closeBtn.style.right = '0';
            closeBtn.style.backgroundColor = 'red';
            closeBtn.style.color = 'white';
            closeBtn.style.borderRadius = '50%';
            closeBtn.style.cursor = 'pointer';
            closeBtn.style.padding = '2px 5px';

            closeBtn.addEventListener('click', function () {
                selectedFiles = selectedFiles.filter(item => item !== file);

                imgContainer.remove();

                updateFileInput();
            });

            imgContainer.appendChild(img);
            imgContainer.appendChild(closeBtn);

            previewContainer.appendChild(imgContainer);
        };

        reader.readAsDataURL(file);
    }
}

function updateFileInput() {
    const fileInput = document.getElementById('images');
    const dataTransfer = new DataTransfer();

    selectedFiles.forEach(file => {
        dataTransfer.items.add(file); 
    });

    fileInput.files = dataTransfer.files; 
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\FPT Polytechnic\php2\view/admin/products/create.blade.php ENDPATH**/ ?>