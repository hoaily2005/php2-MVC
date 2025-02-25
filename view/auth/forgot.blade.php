@extends('layouts.master')
@section('content')
<div class="container mt-5">
    <div class="border rounded p-4 shadow-sm w-50 mx-auto">
        <h2 class="text-center mb-4">Quên Mật Khẩu</h2>
        
        <form action="/forgot-password" method="POST">
        <div class="mb-3">
          <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email của bạn">
        </div>
        
        <button type="submit" class="btn btn-primary w-100">Gửi Email</button>
        <a href="/login" class="btn btn-secondary w-100 mt-3">Quay Lại Đăng Nhập</a>
      </form>
      <?php if (isset($_SESSION['forgot_success'])): ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Thành Công!',
                    text: '<?php echo $_SESSION['forgot_success']; ?>',
                    confirmButtonText: 'OK'
                });
            </script>
            <?php unset($_SESSION['forgot_success']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['forgot_error'])): ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: '<?php echo $_SESSION['forgot_error']; ?>',
                    confirmButtonText: 'OK'
                });
            </script>
            <?php unset($_SESSION['forgot_error']); ?>
        <?php endif; ?>
    </div>
  </div>
  @endsection
