<?php
require_once "model/CategoryModel.php";
require_once "model/UserModel.php";
require_once "model/ProductVariantModel.php";
require_once "view/helpers.php";
require_once "model/CartModel.php";
require_once 'core/BladeServiceProvider.php';

class CartController
{
    private $cartModel;
    private $productVariantModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->productVariantModel = new ProductVariantModel();
    }


    public function index()
    {

        $user_id = $_SESSION['users']['id'] ?? null;
        $session_id = session_id();

        if ($user_id) {
            $this->cartModel->mergeCart($user_id, $session_id);
        }

        // $user_id = $_SESSION['users']['id'] ?? null;
        // $session_id = session_id();
        $carts = $this->cartModel->getCart($user_id, $session_id);
        BladeServiceProvider::render("cart/list", compact('carts'), "carts List");
    }

    public function addCart()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $user_id = $_SESSION['users']['id'] ?? null;
            $cart_session = session_id();
            $sku = $_POST['sku'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;
            $price = $_POST['price'] ?? 0;

            $errors = [];

            if (empty($sku)) {
                $errors[] = "Vui lòng chọn sản phẩm.";
            }

            if ($quantity <= 0) {
                $errors[] = "Số lượng phải lớn hơn 0.";
            }

            if ($price <= 0) {
                $errors[] = "Giá sản phẩm không hợp lệ.";
            }

            $stock = $this->productVariantModel->getStock($sku);
            if ($quantity > $stock) {
                $errors[] = "Số lượng vượt quá số lượng trong kho.";
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: /carts");
                exit;
            }

            $success = $this->cartModel->addCart($user_id, $cart_session, $sku, $quantity, $price);

            if ($success) {
                $_SESSION['success'] = "Sản phẩm đã được thêm vào giỏ hàng!";
                header("Location: /carts");
                exit;
            } else {
                $_SESSION['errors'][] = "Có lỗi xảy ra khi thêm sản phẩm.";
                header("Location: /carts");
                exit;
            }
        } else {
            header("Location: /carts");
            exit;
        }
    }

    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            session_start();
            $user_id = $_SESSION['users']['id'] ?? null;
            $cart_session = session_id();
            $cart_id = $_POST['cart_id'] ?? null;
            $quantity = $_POST['quantity'] ?? null;

            if ($quantity > 0) {
                $success = $this->cartModel->updateCart($user_id, $cart_session, $cart_id, $quantity);

                if ($success) {
                    $_SESSION['success'] = "Cập nhật giỏ hàng thành công!";
                } else {
                    $_SESSION['errors'] = "Có lỗi xảy ra khi cập nhật giỏ hàng.";
                }
            } else {
                $_SESSION['errors'] = "Số lượng phải lớn hơn 0.";
            }

            header("Location: /carts");
            exit();
        }
    }



    public function delete($id)
    {
        session_start();
        $user_id = $_SESSION['users']['id'] ?? null;
        $cart_session = session_id();

        $success = $this->cartModel->deleteCart($user_id, $cart_session, $id);

        if ($success) {
            $_SESSION['success'] = "Xóa sản phẩm thành công!";
        } else {
            $_SESSION['errors'] = "Có lỗi xảy ra khi xóa sản phẩm.";
        }

        header("Location: /carts");
        exit();
    }

    public function deleteAll()
    {
        session_start();
        $user_id = $_SESSION['users']['id'] ?? null;
        $cart_session = session_id();
        $success = $this->cartModel->deleteAll($user_id, $cart_session);

        if ($success) {
            $_SESSION['success'] = "Đã xóa tất cả sản phẩm trong giỏ hàng!";
        } else {
            $_SESSION['errors'] = "Có lỗi xảy ra khi xóa tất cả sản phẩm.";
        }

        header("Location: /carts");
        exit();
    }
   
}
