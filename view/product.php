<br>
<div class="container-fluid">
    <div class="row">
        <!-- Menu lọc bên trái -->
        <div class="col-md-2">
            <h2 class="my-4" style="color: brown;">Bộ lọc</h2>
            <div class="mb-4">
                <div class="mb-3">
                    <label class= "form-label">Danh mục</label><br>
                    <input type="radio" name="category" id="categoryAll" value="" checked>
                    <label for="categoryAll">Tất cả danh mục</label><br>
                    <input type="radio" name="category" id="category1" value="1">
                    <label for="category1">Danh mục 1</label><br>
                    <input type="radio" name="category" id="category2" value="2">
                    <label for="category2">Danh mục 2</label><br>
                    <input type="radio" name="category" id="category3" value="3">
                    <label for="category3">Danh mục 3</label>
                </div>
                <div class="mb-3">
                    <label class= "form-label">Mức giá:</label><br>
                    <input type="radio" name="price" id="priceAll" value="" checked>
                    <label for="priceAll">Tất cả mức giá</label><br>
                    <input type="radio" name="price" id="price0-500000" value="0-500000">
                    <label for="price0-500000">Dưới 500k</label><br>
                    <input type="radio" name="price" id="price500000-1000000" value="500000-1000000">
                    <label for="price500000-1000000">500k - 1Tr</label><br>
                    <input type="radio" name="price" id="price1000000-2000000" value="1000000-2000000">
                    <label for="price1000000-2000000">1TR - 2Tr</label><br>
                    <input type="radio" name="price" id="price2000000" value="2000000-">
                    <label for="price2000000">Trên 2TR</label>
                </div>
                <input type="text" id="searchInput" class="form-control mb-3" placeholder="Tìm kiếm sản phẩm...">
                <button id="filterButton" class="btn btn-primary w-100">Lọc</button>
            </div>
        </div>

        <!-- Danh sách sản phẩm bên phải -->
        <div class="col-md-10">
            <div class="row" id="productList">
                <?php foreach ($products as $index => $product): ?>
                    <div class="col-md-4 mt-3">
                        <div class="card shadow-sm rounded">
                            <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="card-img-top" style="height: 250px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= $product['name'] ?></h5>
                                <p class="card-text">Số lượng: <?= $product['quantity'] ?></p>
                                <p class="card-text text-danger"><strong><?= number_format($product['price'], 0, ',', '.') ?> VND</strong></p>
                                <a href="/products/detail/<?= $product['id'] ?>" class="btn btn-primary btn-sm w-100">Xem Chi Tiết</a>
                            </div>
                        </div>
                    </div>
                    <?php if (($index + 1) % 3 == 0): ?>
                        </div>
                        <div class="row mt-4">
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<style>
    /* Định dạng phần chứa bộ lọc */
.container-fluid .col-md-2 {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

/* Định dạng tiêu đề bộ lọc */
.container-fluid .col-md-2 h2 {
    font-size: 20px;
    font-weight: bold;
}

/* Định dạng radio button */
input[type="radio"] {
    margin-right: 10px;
}

/* Định dạng label cho radio button */
label {
    margin-right: 20px;
    font-size: 14px;
}

/* Định dạng nút Lọc */
#filterButton {
    background-color: brown;
    border-color: brown;
}

/* Định dạng các phần tử khác */
.mb-3 {
    margin-bottom: 15px;
}

.mb-4 {
    margin-bottom: 20px;
}

</style>