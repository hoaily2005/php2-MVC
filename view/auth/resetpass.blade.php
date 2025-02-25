@extends('layouts.master')
@section('content')
<div class="container mt-5">
    <div class="border rounded p-4 shadow-sm w-50 mx-auto">
        <h2 class="text-center mb-4">Đặt lại mật khẩu</h2>
      <form action="/reset-password" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? '', ENT_QUOTES); ?>">

        <div class="mb-3">
          <label for="password" class="form-label">Mật khẩu mới:</label>
          <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="confirm_password" class="form-label">Xác nhận mật khẩu:</label>
          <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Đặt lại mật khẩu</button>
      </form>
     
        <?php if (isset($_SESSION['reset_error'])): ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: '<?php echo $_SESSION['reset_error']; ?>',
                    confirmButtonText: 'OK'
                });
            </script>
            <?php unset($_SESSION['reset_error']); ?>
        <?php endif; ?>
    </div>
  </div>
  @endsection
