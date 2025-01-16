<h1>Create Product</h1>
<form method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?> >
        <div class="text-danger"><?= $errors['name'] ?? ''; ?></div>

    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="4" <?php echo isset($errors['description']) ? 'is-invalid' : ''; ?>></textarea>
        <div class="text-danger"><?= $errors['description'] ?? ''; ?></div>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" id="price" name="price" step="0.01" <?php echo isset($errors['price']) ? 'is-invalid' : ''; ?>>
        <div class="text-danger"><?= $errors['price'] ?? ''; ?></div>

    </div>
    <button type="submit" class="btn btn-success">Create</button>
    <a href="/" class="btn btn-danger">Back to list</a>
</form>