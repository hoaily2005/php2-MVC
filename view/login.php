<h2 class="text-center">Đăng nhập</h2>
<form class="form-control w-50 mx-auto p-3" method="POST">
    <div class="form-group mt-3">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" placeholder="Nhập email">
        <?php
        if (isset($errors['email'])) {
            echo '<div class="invalid-feedback">' . $errors['email'] . '</div>';
        }
        ?>
    </div>
    <div class="form-group mt-3">
        <label for="password">Mật khẩu</label>
        <input type="password" name="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" placeholder="Nhập mật khẩu">
        <?php
        if (isset($errors['password'])) {
            echo '<div class="invalid-feedback">' . $errors['password'] . '</div>';
        }
        ?>
    </div>
    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary">Đăng nhập</button>
        <a href="/register" class="btn btn-secondary">Đăng ký</a>
    </div>
    <?php
    if (isset($errors['login'])) {
        echo '<p class="text-danger">' . $errors['login'] . '</p>';
    }
    ?>
</form>