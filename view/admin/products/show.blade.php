@extends('layouts.admin')
@section('content')
<h1><?= $products['name'] ?></h1>
<p><strong>Description:</strong> <?= $products['description'] ?></p>
<p><strong>Price:</strong> $<?= $products['price'] ?></p>

<h2>Variant Details</h2>
<p><strong>SKU:</strong> <?= $variant['sku'] ?></p>
<p><strong>Color:</strong> <?= $variant['color_name'] ?></p>
<p><strong>Size:</strong> <?= $variant['size_name'] ?></p>
<p><strong>Quantity:</strong> <?= $variant['quantity'] ?></p>
<p><strong>Price:</strong> $<?= $variant['price'] ?></p>

<a href="/" class="btn btn-secondary">Back to List</a>
@endsection
