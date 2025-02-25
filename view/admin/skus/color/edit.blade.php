@extends('layouts.admin')
@section('content')
<h1>Edit size</h1>
<form method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $color['name'] ?>">
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
</form>
@endsection