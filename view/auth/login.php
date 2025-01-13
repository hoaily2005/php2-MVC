    <style>
        .login-container {
            width: 360px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            margin: auto;
            margin-top: 80px;
        }
        .form-control {
            border: none;
            color: #000000;
        }
        .form-control::placeholder {
            color: #aaa;
        }
        .form-control:focus {
            border: 1px solid #ff424e;
            color: #000000;
            box-shadow: none;
        }
        .btn-garena {
            background-color: #ff424e;
            color:rgb(255, 255, 255);
            font-weight: bold;
            transition: 0.3s;
            border-radius: 5px;
        }
        .btn-garena:hover {
            background-color: #e03641;
        }
        .register-link a {
            color: #ff424e;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>

<div class="login-container">
    <h2 class="text-center mb-4">Đăng Nhập</h2>

    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email của bạn">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label"><i class="fas fa-lock"></i> Mật Khẩu</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu của bạn">
        </div>
        <div class="mb-3 text-end">
            <a href="#" class="text-decoration-none text-danger">Quên mật khẩu?</a>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-garena btn-lg">Đăng Nhập</button>
        </div>
        <div class="mt-3 text-center register-link">
            <p>Bạn chưa có tài khoản? <a href="/register">Đăng ký ngay</a></p>
        </div>
    </form>

    <?php if (isset($_SESSION['login_failed'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi Đăng Nhập!',
                text: 'Email hoặc mật khẩu không chính xác.',
                confirmButtonText: 'Thử lại'
            });
        </script>
        <?php unset($_SESSION['login_failed']); ?>
    <?php endif; ?>
</div>
