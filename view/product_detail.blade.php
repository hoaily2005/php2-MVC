@extends('layouts.master')
@section('content')
<div class="mt-3">
    <div class="row">
        <div class="col-md-6">
            <img src="http://localhost:8000/<?php echo $products['image']; ?>" class="img-fluid image-format" alt="Elden Ring">
            <a href="#" class="d-block mt-2 text-center text-primary" data-bs-toggle="modal" data-bs-target="#imageModal">Xem thêm ảnh</a>
        </div>
        <!-- Chi tiết sản phẩm -->
        <div class="col-md-6">
            <h3><strong><?php echo $products['name']; ?></strong></h3>
            <p class="text-danger"><button class="btn btn-success" style="font-size: 16px;" id="stock">Tồn kho: <?php echo $products['quantity']; ?></button></p>
            <div id="variant-info">
                <h4 class="text-danger"><?php echo number_format($products['price'], 0, ',', '.'); ?>đ</h4>
                <p class="text-muted">
                    <del id = "price_variants"><?php echo number_format($products['price'], 0, ',', '.'); ?>đ</del> <span class="badge bg-danger">-1%</span>
                </p>

                <!-- Chọn màu -->
                <div class="form-group mb-4">
                    <label class="d-block mb-2"><strong>Chọn màu</strong></label>
                    <div id="color-buttons" class="d-flex flex-wrap gap-2" role="group" aria-label="Color select">
                        <?php 
                            $uniqueColors = array_unique(array_column($variants, 'color_name')); // Lọc các màu sắc duy nhất
                            foreach ($uniqueColors as $color): ?>
                                <div class="color-option">
                                    <input type="radio" id="color-<?= $color ?>" name="color" class="btn-check" data-color="<?= $color ?>" />
                                    <label class="color-label" for="color-<?= $color ?>">
                                        <span class="color-name"><?= $color ?></span>
                                    </label>
                                </div>
                        <?php endforeach; ?>
                    </div>
                </div>


                <!-- Chọn Size -->
                <div class="form-group mb-4">
                    <label class="d-block mb-2"><strong>Chọn Size</strong></label>
                    <div id="size-buttons" class="d-flex flex-wrap gap-2" role="group" aria-label="Size select">
                        <?php 
                            $uniqueSizes = array_unique(array_column($variants, 'size_name')); // Lọc các size duy nhất
                            foreach ($uniqueSizes as $size): ?>
                                <div class="size-option">
                                    <input type="radio" id="size-<?= $size ?>" name="size" class="btn-check" data-size="<?= $size ?>" />
                                    <label class="size-label" for="size-<?= $size ?>">
                                        <?= $size ?>
                                    </label>
                                </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <form action="/carts/addToCart" method="POST" id="cartForm">
                    <input type="hidden" name="sku" value="">
                    <input type="hidden" name="price" value="">

                    <div class="d-flex align-items-center">
                        <label for="quantity" class="me-2"><strong>Số lượng:</strong></label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control w-25">
                    </div>
                    <hr>
                    <div class="d-flex gap-2">
                        <a href="/" class="btn btn-danger">Quay lại</a>
                        <button type="submit" id="addToCart" class="btn btn-success" style="display: block;">Thêm Vào Giỏ Hàng</button>
                    </div>
                </form>

                <hr>
            </div>


            <p>Loại: </p>
            <div class="mb-3 d-flex gap-2 flex-wrap">
                <button class="btn btn-outline-primary">Sản Phẩm mới</button>
                <button class="btn btn-outline-primary">Sản phẩm đáng tin cậy</button>
                <button class="btn btn-outline-primary">Sản phẩm ưa chuộng</button>
            </div>

        </div>
    </div>
    <!-- add carts -->
    <!-- Form thêm vào giỏ hàng -->


    <h4 class="mt-3">Mô tả</h4>
    <p><?php echo $products['description']; ?></p>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="fullImage" src="" class="img-fluid">
            </div>
        </div>
    </div>
</div>


<h4 class="mt-4">Sản phẩm liên quan</h4>
<div class="row">
    @foreach ($relatedProducts as $relatedProduct)
        <div class="col-md-3">
            <div class="card">
                <img src="http://localhost:8000/{{ $relatedProduct['image'] }}" class="card-img-top" alt="{{ $relatedProduct['name'] }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $relatedProduct['name'] }}</h5>
                    <p class="card-text">{{ number_format($relatedProduct['price'], 0, ',', '.') }} đ</p>
                    <a href="/products/detail/{{ $relatedProduct['id'] }}" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("cartForm");
    const skuInput = form.querySelector("input[name='sku']");
    const priceInput = form.querySelector("input[name='price']");
    const quantityInput = form.querySelector("input[name='quantity']");
    const addToCartBtn = document.getElementById("addToCart");
    const productImage = document.querySelector(".image-format");
    const stockInfoButton = document.getElementById("stock");
    const priceDisplay = document.querySelector("#variant-info h4.text-danger");
    const originalPriceDisplay = document.querySelector("#price_variants");

    const variants = <?php echo json_encode($variants); ?>;

    function updateFormValues() {
        const selectedColor = document.querySelector("input[name='color']:checked");
        const selectedSize = document.querySelector("input[name='size']:checked");

        let selectedVariant = null;

        if (selectedColor && selectedSize) {
            selectedVariant = variants.find(variant => 
                variant.color_name === selectedColor.dataset.color && 
                variant.size_name === selectedSize.dataset.size
                
            );
        } else if (selectedColor) {
            selectedVariant = variants.find(variant => variant.color_name === selectedColor.dataset.color);
        } else if (selectedSize) {
            selectedVariant = variants.find(variant => variant.size_name === selectedSize.dataset.size);
        }

        if (selectedVariant) {
            skuInput.value = selectedVariant.sku;
            priceInput.value = selectedVariant.price;
            productImage.src = selectedVariant.image;
            stockInfoButton.textContent = `Tồn kho: ${selectedVariant.quantity}`;
            productImage.src = "http://localhost:8000/" + selectedVariant.image;
 
            // Cập nhật giá hiển thị
            priceDisplay.textContent = `${parseInt(selectedVariant.price).toLocaleString('vi-VN')}đ`;
            originalPriceDisplay.textContent = `${(parseInt(selectedVariant.price) * 1.1).toLocaleString('vi-VN')}đ`; 
        }
    }

    document.querySelectorAll("input[name='color'], input[name='size']").forEach(input => {
        input.addEventListener("change", updateFormValues);
    });

    addToCartBtn.addEventListener("click", function(event) {
        updateFormValues();
        form.submit();
    });
    updateFormValues();
});

</script>
<style>
    .image-format {
    width: 100%;
    max-height: 600px;
    object-fit: contain;
    cursor: pointer;
}

.btn-group {
    margin-bottom: 10px;
}

.modal-content {
    border-radius: 10px;
}

.btn-check:checked+.btn-outline-primary {
    background-color: rgb(233, 58, 78);
    color: white;
}

.input-group {
    max-width: 150px;
    display: flex;
    align-items: center;
}

#quantity {
    text-align: center;
    width: 50px;
    padding: 5px;
}

.color-option,
.size-option {
    position: relative;
}

.color-label,
.size-label {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.color-label:hover,
.size-label:hover {
    border-color: #cbd5e0;
    background-color: #f7fafc;
}

.btn-check:checked+.color-label,
.btn-check:checked+.size-label {
    border-color: #DC1E35;
    background-color: #eff6ff;
}

.color-swatch {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 1px solid #e2e8f0;
}

.color-name {
    font-size: 0.9rem;
}

.size-label {
    min-width: 60px;
    justify-content: center;
    font-size: 0.9rem;
    font-weight: 500;
}

.btn-check:disabled+.color-label,
.btn-check:disabled+.size-label {
    opacity: 0.5;
    cursor: not-allowed;
}

@keyframes select-pop {
    0% {
        transform: scale(0.95);
    }

    50% {
        transform: scale(1.02);
    }

    100% {
        transform: scale(1);
    }
}

.btn-check:checked+.color-label,
.btn-check:checked+.size-label {
    animation: select-pop 0.2s ease-out;
}

</style>
@endsection
