<h1 class="text-center">Đăng kí tài khoản</h1>
<form method="POST" class="w-50 mx-auto p-3">
<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?? '' ?>">
    <?php if (isset($errors['email'])): ?>
        <div class="text-danger"><?= $errors['email']; ?></div>
    <?php endif; ?>
</div>
<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?? '' ?>">
    <?php if (isset($errors['name'])): ?>
        <div class="text-danger"><?= $errors['name']; ?></div>
    <?php endif; ?>
</div>
<div class="mb-3">
    <label for="phone" class="form-label">Phone</label>
    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone ?? '' ?>">
    <?php if (isset($errors['phone'])): ?>
        <div class="text-danger"><?= $errors['phone']; ?></div>
    <?php endif; ?>
</div>
<div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <input type="text" class="form-control" id="address" name="address" value="<?php echo $address ?? '' ?>">
    <?php if (isset($errors['address'])): ?>
        <div class="text-danger"><?= $errors['address']; ?></div>
    <?php endif; ?>
</div>
<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" value="<?php echo $password ?? '' ?>">
    <?php if (isset($errors['password'])): ?>
        <div class="text-danger"><?= $errors['password']; ?></div>
    <?php endif; ?>
</div>
<button type="submit" class="btn btn-primary">Đăng ký</button>
<a href="/login" class="btn btn-secondary">Đăng nhập</a>
</form>
