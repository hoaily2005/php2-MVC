<?php
$total = 0;

if (!empty($carts)) {
    foreach ($carts as $cart) {
        $total += $cart['price'] * $cart['quantity'];
    }
}

?>

<div class="container">
    <h1>Giỏ Hàng</h1>

    <section class="cart-items">
        <table>
            <thead>
                <tr>
                    <th>Ảnh Sản Phẩm</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Kích Cỡ</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="cart-items">
                <?php
                if (empty($carts)) {
                    echo '<tr><td colspan="6">Giỏ Hàng Trống.</td></tr>';
                } else {
                    foreach ($carts as $cart) {
                        // echo '<pre>';
                        // print_r($cart);
                        // echo '</pre>';
                        $product_image = $cart['image'];
                        $product_name = $cart['name'];
                        $product_sku = $cart['color_name'] . ' - ' . $cart['size_name'];
                        $product_price = $cart['price'];
                        $product_quantity = $cart['quantity'];
                        $product_total = $product_price * $product_quantity;
                ?>
                        <tr>
                            <td><img src="http://localhost:8000/<?php echo $product_image; ?>" alt="Product Image" style="width: 80px; height: auto;" /></td>
                            <td><?php echo $product_name; ?></td>
                            <td><?php echo $product_sku; ?></td>
                            <td>
                                <form action="/carts/update" method="POST" class="d-flex align-items-center">
                                    <input type="number" class="form-control text-center me-2" name="quantity" value="<?= $cart['quantity'] ?>" min="1" required>
                                    <input type="hidden" class="form-control" name="cart_id" value="<?= $cart['id'] ?>">
                                    <button type="submit" class="btn btn-warning">Update</button>
                                </form>

                            </td>
                            <td><?php echo number_format($product_price, 0, ',', '.') . ' VND'; ?></td>
                            <td>
                                <a href="/carts/delete/<?= $cart['id'] ?>"><i class="fa-solid fa-circle-xmark"></i></a>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </section>

    <!-- Cart Summary -->
    <section class="cart-summary">
        <div class="d-flex justify-content-end">
            <form action="/carts/deleteAll" method="POST">
                <button type="submit" class="btn btn-danger">Xóa tất cả sản phẩm</button>
            </form>
        </div>

        <hr class="my-4 border-dark">
        <div>
            <p><strong>Tổng cộng:</strong> <span id="total"><?php echo number_format($total, 0, ',', '.'); ?></span></p>
        </div>


        <form action="/checkout" method="POST" id="checkoutForm">
            <input type="hidden" name="cart_data" id="cart_data">
            <button type="submit" class="btn btn-primary">Thanh Toán</button>
        </form>
    </section>
    <?php
    // echo "<pre>";
    // var_dump($cart);
    // echo "s</pre>";
    ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateSummary() {
            let total = 0;
            document.querySelectorAll('.cart-items tbody tr').forEach(row => {
                let priceText = row.querySelector('td:nth-child(5)').textContent.replace(' VND', '').replace(/\./g, '');
                let price = parseFloat(priceText) || 0;
                let quantity = parseInt(row.querySelector('input[name="quantity"]').value) || 1;
                total += price * quantity;
            });

            document.getElementById('total').textContent = total.toLocaleString('vi-VN') + ' VND';

            const cartData = [];
            document.querySelectorAll('.cart-items tbody tr').forEach(row => {
                const productName = row.querySelector('td:nth-child(2)').textContent;
                const quantity = row.querySelector('input[name="quantity"]').value;
                const price = row.querySelector('td:nth-child(5)').textContent.replace(' VND', '').replace(/\./g, '');
                const productTotal = price * quantity;

                cartData.push({
                    product_name: productName,
                    quantity: quantity,
                    price: price,
                    total: productTotal
                });
            });

            document.getElementById('cart_data').value = JSON.stringify(cartData);
        }


        document.querySelectorAll('input[name="quantity"]').forEach(input => {
            input.addEventListener('input', updateSummary);
        });

        updateSummary();
    });
</script>
<?php if (isset($_SESSION['errors'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: 'Sản phẩm vượt quá số lượng tồn kho!',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
    }

    i.fa-circle-xmark {
        color: red;
        font-size: 20px;
        transition: color 0.3s ease-in-out;
    }

    i.fa-circle-xmark:hover {
        color: darkred;
    }

    /* .container {
        width: 90%;
        max-width: 1100px;
        margin: 30px auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    } */

    h1 {
        text-align: center;
        color: #333;
        font-size: 26px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .cart-items table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 8px;
        overflow: hidden;
    }

    .cart-items th {
        background-color: #17a2b8;
        color: white;
        padding: 12px;
        text-align: center;
        font-weight: 600;
    }

    .cart-items td {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .cart-items img {
        width: 70px;
        height: auto;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .quantity {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .qty-btn {
        width: 30px;
        height: 30px;
        border: none;
        background-color: #28a745;
        color: white;
        font-size: 18px;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    .qty-btn:hover {
        background-color: #218838;
    }

    .qty-input {
        width: 40px;
        text-align: center;
        font-size: 16px;
        border: 1px solid #ccc;
        margin: 0 5px;
        border-radius: 5px;
        padding: 5px;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
        padding: 8px 12px;
        color: white;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
        font-size: 14px;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .cart-summary {
        margin-top: 20px;
        padding: 15px;
        background: #f1f1f1;
        border-radius: 8px;
    }

    .cart-summary div {
        font-size: 18px;
        font-weight: 500;
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .cart-summary strong {
        color: #333;
    }

    .checkout-button {
        display: block;
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 18px;
        font-weight: 600;
        text-align: center;
        border-radius: 5px;
        transition: 0.3s;
    }

    .checkout-button:hover {
        background-color: #0056b3;
    }
</style>