@extends('layouts.admin')
@section('content')
<h1>Create Catetgory</h1>
<form method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= isset($name) ? $name : ''; ?>">
        <?php if (isset($errors['name'])): ?>
            <div class="text-danger"><?= $errors['name']; ?></div>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description"  rows="4"><?= isset($description) ? $description : ''; ?></textarea>
        <?php if (isset($errors['description'])): ?>
            <div class="text-danger"><?= $errors['description']; ?></div>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-success">Create</button>
    <a href="/" class="btn btn-danger">Back to list</a>
</form>
@endsection