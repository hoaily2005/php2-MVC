@extends('layouts.admin')
@section('content')
<h1>Thêm kích cỡ</h1>
<form method="POST">
    <div class="mb-3">
        <label for="size" class="form-label">Size</label>
        <input type="text" class="form-control" id="name" name="name">
    </div>
    <button type="submit" class="btn btn-success">Thêm</button>
    <a href="/admin" class="btn btn-danger">Thoát</a>
</form>
@endsection