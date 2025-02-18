<?php

use Illuminate\Support\Facades\Blade;

require_once "model/CategoryModel.php";
require_once "model/UserModel.php";
require_once "model/ProductVariantModel.php";
require_once "model/CartModel.php";
require_once "view/helpers.php";
require_once "model/OrderModel.php";
require_once 'core/BladeServiceProvider.php';


class OrderController
{
    private $orderModel;
    private $cartModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->cartModel = new CartModel();
    }

    public function index()
    {
        $user_id = $_SESSION['users']['id'] ?? null;

        if ($user_id) {
            $orders = $this->orderModel->getOrders($user_id);
            BladeServiceProvider::render("order/list", compact('orders'), "Order List");
        } else {
            header("Location: /login");
            exit();
        }
    }

    public function admin()
    {
        $orders = $this->orderModel->getAllOrders();
        BladeServiceProvider::render("order/admin", compact('orders'), "orders List", 'admin');
    }



    public function show($id)
    {
        $order = $this->orderModel->getOrderById($id);
        if ($order) {
            BladeServiceProvider::render("order/show", compact('order'), "Order Detail");
        } else {
            BladeServiceProvider::render("unauthorized", ['message' => 'Order not found'], "Error");
        }
    }


    public function createOrder()
    {
        $user_id = $_SESSION['users']['id'] ?? null;
        $cart_session = session_id();

        if ($user_id) {
            $carts = $this->cartModel->getCart($user_id, $cart_session);
        } else {
            $carts = $this->cartModel->getCart(null, $cart_session);
        }

        $totalPrice = 0;
        foreach ($carts as $cart) {
            $totalPrice += $cart['price'] * $cart['quantity'];
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $payment_method = $_POST['payment_method'] ?? null;
            $payment_status = $_POST['payment_status'] ?? 'Pending';
            $shipping_address = $_POST['address'] ?? null;
            $total_price = $_POST['total_price'] ?? $totalPrice;

            if ($user_id && $payment_method && $shipping_address && $total_price > 0) {
                $isCreated = $this->orderModel->createOrder($user_id, $payment_method, $payment_status, $shipping_address, $total_price);

                if ($isCreated) {
                    $order_id = $this->orderModel->getLastInsertId();

                    foreach ($carts as $cart) {
                        $this->orderModel->addOrderItem($order_id, $cart['sku'], $cart['price'], $cart['quantity']);
                    }

                    $this->cartModel->clearCart($user_id);

                    $message = "Order created successfully!";
                    BladeServiceProvider::render("order_success", ['message' => $message], "Order Success");
                } else {
                    $message = "Failed to create order.";
                    BladeServiceProvider::render("checkout/check_out", ['message' => $message, 'carts' => $carts], "Create Order");
                }
            } else {
                $message = "Please fill in all required fields.";
                BladeServiceProvider::render("checkout/check_out", ['message' => $message, 'carts' => $carts], "Create Order");
            }
        } else {
            BladeServiceProvider::render("checkout/check_out", ['carts' => $carts], "Create Order");
        }
    }


    public function delete($id)
    {
        $this->orderModel->delete($id);
        $_SESSION['success'] = "Xóa color thành công";
        header("Location: /admin/orders");
    }

    public function updateStatus($order_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_status'])) {
            $payment_status = $_POST['payment_status'];

            $isUpdated = $this->orderModel->updateOrderStatus($order_id, $payment_status);

            if ($isUpdated) {
                $_SESSION['success'] = "Cập nhật trạng thái thành công";
                header("Location: /admin/orders");
                exit();
            } else {
                echo "Lỗi không thể cập nhập trạng thái.";
            }
        }
    }
}
