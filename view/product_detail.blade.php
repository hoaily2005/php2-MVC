@extends('layouts.master')
@section('content')
<div class="mt-3">
    <!-- Hiển thị thông báo -->
    <?php 
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    ?>

    <?php if (isset($error)): ?>
        <p class="text-danger"><?php echo $error; ?></p>
    <?php elseif (isset($products) && $products): ?>
        <div class="row">
            <div class="col-md-6">
                <img src="http://localhost:8000/<?php echo $products['image']; ?>" class="img-fluid image-format" alt="<?php echo $products['name']; ?>">
                <a href="#" class="d-block mt-2 text-center text-primary" data-bs-toggle="modal" data-bs-target="#imageModal">Xem thêm ảnh</a>
            </div>
            <!-- Chi tiết sản phẩm -->
            <div class="col-md-6">
                <h3><strong><?php echo $products['name']; ?></strong></h3>
                <p class="text-danger">
                    <?php 
                        if ($products['quantity'] <= 0) {
                            echo '<button class="btn btn-danger" style="font-size: 16px;" id="stock">Hết hàng</button>';
                        } else {
                            echo '<button class="btn btn-success" style="font-size: 16px;" id="stock">Tồn kho: ' . $products['quantity'] . '</button>';
                        }
                    ?>
                </p>
                
                <div id="variant-info">
                    <h4 class="text-danger"><?php echo number_format($products['price'], 0, ',', '.'); ?>đ</h4>
                    <p class="text-muted">
                        <del id="price_variants"><?php echo number_format($products['price'], 0, ',', '.'); ?>đ</del> <span class="badge bg-danger">-1%</span>
                    </p>

                    <!-- Chọn màu -->
                    <div class="form-group mb-4">
                        <label class="d-block mb-2"><strong>Chọn màu</strong></label>
                        <div id="color-buttons" class="d-flex flex-wrap gap-2" role="group" aria-label="Color select">
                            <?php 
                                $uniqueColors = array_unique(array_column($variants, 'color_name'));
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
                                $uniqueSizes = array_unique(array_column($variants, 'size_name'));
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

        <h4 class="mt-3">Mô tả</h4>
        <p><?php echo $products['description']; ?></p>
        
        
        <h4 class="mt-3">Đánh giá sản phẩm</h4>
        <p><strong>Đánh giá trung bình:</strong> <?php echo $averageRating; ?> ★</p>

        <?php if (isset($_SESSION['users']['id'])): ?>
            <form action="/ratings/create" method="POST" id="ratingForm">
                <input type="hidden" name="product_id" value="<?= $products['id'] ?>">
                <input type="hidden" name="rating" id="rating_value" value="">
                <div class="d-flex align-items-center">
                    <label for="rating" class="me-2"><strong>Đánh giá:</strong></label>
                    <div class="stars" id="star-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="star" data-value="<?php echo $i; ?>">★</span>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="comment"><strong>Bình luận của bạn:</strong></label>
                    <textarea id="comment" name="comment" class="form-control" rows="3" placeholder="Nhập bình luận của bạn..."></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Gửi đánh giá</button>
                </div>
            </form>
        <?php else: ?>
            <p>Vui lòng <a href="/login">đăng nhập</a> để đánh giá sản phẩm.</p>
        <?php endif; ?>

        <br>
        <h5>Đánh giá của khách hàng:</h5>
        <div id="ratings-list">
            <?php if (!empty($ratings)): ?>
                <?php foreach ($ratings as $rating): ?>
                    <div class="rating-item mb-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <!-- Username and Rating -->
                            <div class="d-flex align-items-center">
                                <p class="me-3 fw-bold text-dark"><?php echo $rating['name']; ?></p>
                                <div class="rating-stars">
                                    <?php for ($i = 0; $i < $rating['rating']; $i++): ?>
                                        <span class="star selected">★</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            
                            <!-- Rating Date -->
                            <div class="ms-2 text-muted small"><?php echo date('d M Y', strtotime($rating['created_at'])); ?></div>
                        </div>
                        <p class="mt-2 text-muted"><?php echo htmlspecialchars($rating['comment'] ?? ''); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-muted">Chưa có đánh giá cho sản phẩm này.</p>
            <?php endif; ?>
        </div>
        
    <?php endif; ?>
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

<hr>

<?php if (isset($relatedProducts) && !empty($relatedProducts)): ?>
    <h4 class="mt-4">Sản phẩm liên quan</h4>
    <div class="row">
        <?php foreach ($relatedProducts as $relatedProduct): ?>
            <div class="col-md-3">
                <div class="card">
                    <img src="http://localhost:8000/<?php echo $relatedProduct['image']; ?>" class="card-img-top" alt="<?php echo $relatedProduct['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $relatedProduct['name']; ?></h5>
                        <p class="card-text"><?php echo number_format($relatedProduct['price'], 0, ',', '.'); ?> đ</p>
                        <a href="/products/detail/<?php echo $relatedProduct['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

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
            productImage.src = "http://localhost:8000/" + selectedVariant.image;
            priceDisplay.textContent = `${parseInt(selectedVariant.price).toLocaleString('vi-VN')}đ`;
            originalPriceDisplay.textContent = `${(parseInt(selectedVariant.price) * 1.1).toLocaleString('vi-VN')}đ`; 
            stockInfoButton.textContent = selectedVariant.quantity <= 0 ? "Hết hàng" : `Tồn kho: ${selectedVariant.quantity}`;
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

    const stars = document.querySelectorAll('#star-rating .star');
    const ratingInput = document.querySelector('#rating_value');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const ratingValue = this.getAttribute('data-value');
            ratingInput.value = ratingValue;
            updateStars(ratingValue);
        });
    });

    function updateStars(ratingValue) {
        stars.forEach(star => {
            if (star.getAttribute('data-value') <= ratingValue) {
                star.classList.add('selected');
            } else {
                star.classList.remove('selected');
            }
        });
    }

    if (ratingInput.value) {
        updateStars(ratingInput.value);
    }
});
</script>

<style>
    #ratings-list {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.rating-item {
    background-color: #ffffff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
}

.rating-stars {
    color: #ffc107; /* Gold color */
    font-size: 18px;
}

.star.selected {
    color: #f39c12;
}

.text-muted {
    color: #6c757d;
}

.fw-bold {
    font-weight: bold;
}

.text-dark {
    color: #343a40;
}

.small {
    font-size: 0.875rem;
}

p {
    font-size: 14px;
}

.me-3 {
    margin-right: 1rem;
}

.ms-2 {
    margin-left: 0.5rem;
}

.mb-4 {
    margin-bottom: 1.5rem;
}

.mb-3 {
    margin-bottom: 1rem;
}

.mt-2 {
    margin-top: 0.5rem;
}

.star {
    font-size: 30px;
    cursor: pointer;
    color: #ccc;
}

.star.selected {
    color: gold;
}

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
    0% { transform: scale(0.95); }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
}

.btn-check:checked+.color-label,
.btn-check:checked+.size-label {
    animation: select-pop 0.2s ease-out;
}
</style>
@endsection