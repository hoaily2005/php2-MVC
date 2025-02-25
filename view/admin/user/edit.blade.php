@extends('layouts.admin')
@section('content')
<h1>Chỉnh sửa thông tin người dùng <?php echo $user['id']; ?></h1>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form action="/admin/users/edit/<?php echo $user['id']; ?>" method="POST">
    <div class="form-group">
        <label for="name">Tên:</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" required>
    </div>
    <div class="form-group">
        <label for="phone">Số điện thoại:</label>
        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>
    </div>
    <div class="form-group">
        <label for="role">Vai trò:</label>
        <select class="form-control" id="role" name="role">
            <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
            <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>

@endsection
