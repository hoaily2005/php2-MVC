@extends('layouts.master')
@section('content')

<div class="profile-page">
    <div class="card profile-card">
        <div class="profile-header">
            <div class="cover-photo"></div>
            <div class="profile-info">
                <div class="avatar">
                    <img src="https://cdn-icons-png.flaticon.com/512/9815/9815472.png" alt="avatar">
                </div>
                <h1 class="username"><?php echo htmlspecialchars($user['name']); ?></h1>
            </div>
        </div>

        <div class="tabs">
            <button class="tab active" onclick="showTab('personal')">Thông tin cá nhân</button>
            <button class="tab" onclick="showTab('password')">Đổi mật khẩu</button>
        </div>

        <div id="personal" class="tab-content active">
            <form method="POST" action="/profile/update/<?php echo $user['id']; ?>" class="profile-form">
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="<?php echo $user['email']; ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn primary">Cập nhật thông tin</button>
                    <a href="/" class="btn secondary">Quay lại trang chủ</a>
                </div>
            </form>
        </div>

        <div id="password" class="tab-content">
            <form method="POST" action="/profile/password/<?php echo $user['id']; ?>" class="profile-form">
                <div class="form-group">
                    <label for="current-password">Mật khẩu hiện tại</label>
                    <div class="password-input">
                        <input type="password" id="current-password" name="password" required>
                        <i class="toggle-password fas fa-eye"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="new-password">Mật khẩu mới</label>
                    <div class="password-input">
                        <input type="password" id="new-password" name="newpass" required>
                        <i class="toggle-password fas fa-eye"></i>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn primary">Cập nhật mật khẩu</button>
                    <a href="/" class="btn secondary">Quay lại trang chủ</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php if (isset($_SESSION['error'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: '<?= $_SESSION['error']; ?>',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<?php if (isset($_SESSION['success'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '<?= $_SESSION['success']; ?>!',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<style>
.profile-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    padding: 2rem;
    display: flex;
    justify-content: center;
    align-items: flex-start;
}

.profile-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 800px;
    overflow: hidden;
}

.profile-header {
    position: relative;
}

.cover-photo {
    height: 200px;
    background: linear-gradient(45deg, #2196F3, #3F51B5);
}

.profile-info {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: -75px;
    padding-bottom: 20px;
}

.avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 5px solid white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    margin-bottom: 15px;
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.username {
    font-size: 24px;
    color: #333;
    margin: 0;
}

.tabs {
    display: flex;
    border-bottom: 1px solid #eee;
    padding: 0 20px;
}

.tab {
    padding: 15px 30px;
    border: none;
    background: none;
    cursor: pointer;
    font-size: 16px;
    color: #666;
    position: relative;
}

.tab.active {
    color: #2196F3;
}

.tab.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    height: 2px;
    background: #2196F3;
}

.tab-content {
    display: none;
    padding: 30px;
}

.tab-content.active {
    display: block;
}

.profile-form {
    max-width: 500px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #333;
    font-weight: 500;
}

.form-group input {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #eee;
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s ease;
}

.form-group input:focus {
    border-color: #2196F3;
    box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
    outline: none;
}

.form-group input:disabled {
    background: #f5f5f5;
    cursor: not-allowed;
}

.password-input {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #666;
}

.button-group {
    display: flex;
    gap: 15px;
    margin-top: 30px;
}

.btn {
    flex: 1;
    padding: 12px 25px;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    text-decoration: none;
}

.btn.primary {
    background: #2196F3;
    color: white;
    border: none;
}

.btn.primary:hover {
    background: #1976D2;
}

.btn.secondary {
    background: #f5f5f5;
    color: #333;
    border: 1px solid #ddd;
}

.btn.secondary:hover {
    background: #ebebeb;
}

@media (max-width: 768px) {
    .profile-page {
        padding: 1rem;
    }
    
    .button-group {
        flex-direction: column;
    }
    
    .tabs {
        padding: 0 10px;
    }
    
    .tab {
        padding: 15px 20px;
    }
}
</style>

<script>
function showTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    
    document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    document.getElementById(tabName).classList.add('active');
    
    event.target.classList.add('active');
}

document.querySelectorAll('.toggle-password').forEach(toggle => {
    toggle.addEventListener('click', function() {
        const input = this.previousElementSibling;
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
});
</script>

@endsection