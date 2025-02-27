@extends('layouts.master')

@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <!-- Menu lọc bên trái -->
        <div class="col-md-2">
            <h2 class="my-4" style="color: brown;">Bộ lọc</h2>
            <div class="mb-4">
                <!-- Lọc theo danh mục -->
                <div class="mb-3">
                    <form action="" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Danh mục</label><br>
                            <input type="radio" name="category" value="" {{ !isset($_GET['category']) ? 'checked' : '' }}> Tất cả danh mục<br>
                            @foreach ($categories as $category)
                                <input type="radio" name="category" value="{{ $category['id'] }}" {{ isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'checked' : '' }}> {{ $category['name'] }}<br>
                            @endforeach
                        </div>
                    
                        <div class="mb-3">
                            <label class="form-label">Mức giá:</label><br>
                            <input type="radio" name="price" value="" {{ !isset($_GET['price']) ? 'checked' : '' }}> Tất cả mức giá<br>
                            <input type="radio" name="price" value="0-500000" {{ isset($_GET['price']) && $_GET['price'] == '0-500000' ? 'checked' : '' }}> Dưới 500k<br>
                            <input type="radio" name="price" value="500000-1000000" {{ isset($_GET['price']) && $_GET['price'] == '500000-1000000' ? 'checked' : '' }}> 500k - 1Tr<br>
                            <input type="radio" name="price" value="1000000-2000000" {{ isset($_GET['price']) && $_GET['price'] == '1000000-2000000' ? 'checked' : '' }}> 1TR - 2Tr<br>
                            <input type="radio" name="price" value="2000000-" {{ isset($_GET['price']) && $_GET['price'] == '2000000-' ? 'checked' : '' }}> Trên 2TR<br>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Sắp xếp theo:</label><br>
                            <select name="sort" class="form-control">
                                <option value="newest" {{ isset($_GET['sort']) && $_GET['sort'] == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="oldest" {{ isset($_GET['sort']) && $_GET['sort'] == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                                <option value="name_asc" {{ isset($_GET['sort']) && $_GET['sort'] == 'name_asc' ? 'selected' : '' }}>A-Z</option>
                                <option value="name_desc" {{ isset($_GET['sort']) && $_GET['sort'] == 'name_desc' ? 'selected' : '' }}>Z-A</option>
                                <option value="price_asc" {{ isset($_GET['sort']) && $_GET['sort'] == 'price_asc' ? 'selected' : '' }}>Giá thấp -> cao</option>
                                <option value="price_desc" {{ isset($_GET['sort']) && $_GET['sort'] == 'price_desc' ? 'selected' : '' }}>Giá cao -> thấp</option>
                            </select>
                        </div>
                        
                        <input type="submit" value="Lọc" class="btn btn-primary w-100">
                    </form>
                    
                </div>
            </div>
        </div>

        <div class="col-md-10">
            <div class="row" id="productList">
                @if(empty($products) || count($products) == 0)
                    <div class="col-12">
                        <p class="text-center">Không có sản phẩm phù hợp với bộ lọc của bạn.</p>
                    </div>
                @else
                    @foreach ($products as $index => $product)
                        <div class="col-md-4 mt-3">
                            <div class="card shadow-sm rounded">
                                <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="card-img-top" style="height: 250px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product['name'] }}</h5>
                                    <p class="card-text">Số lượng: {{ $product['quantity'] }}</p>
                                    <p class="card-text text-danger"><strong>{{ number_format($product['price'], 0, ',', '.') }} VND</strong></p>
                                    <a href="/products/detail/{{ $product['id'] }}" class="btn btn-primary btn-sm w-100">Xem Chi Tiết</a>
                                </div>
                            </div>
                        </div>
                        @if (($index + 1) % 3 == 0)
                            </div>
                            <div class="row mt-4">
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.container-fluid .col-md-2 {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.container-fluid .col-md-2 h2 {
    font-size: 20px;
    font-weight: bold;
}

input[type="radio"] {
    margin-right: 10px;
}

label {
    margin-right: 20px;
    font-size: 14px;
}

#filterButton {
    background-color: brown;
    border-color: brown;
}

.mb-3 {
    margin-bottom: 15px;
}

.mb-4 {
    margin-bottom: 20px;
}

</style>
@endsection
