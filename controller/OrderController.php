<?php
require_once "model/CategoryModel.php";
require_once "model/UserModel.php";
require_once "model/ProductVariantModel.php";
require_once "model/CartModel.php";
require_once "view/helpers.php";
require_once "model/OrderModel.php";

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
        $orders = $this->orderModel->getOrders();
        renderView("view/admin/order/list.php", compact('orders'), "Order List", 'admin');
    }

    public function show($id)
    {
        $order = $this->orderModel->getOrderById($id);
        if ($order) {
            renderView("view/admin/order/show.php", compact('order'), "Order Detail", 'admin');
        } else {
            renderView("view/admin/order/error.php", ['message' => 'Order not found'], "Error", 'admin');
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
                    renderView("view/order_success.php", ['message' => $message], "Order Success");
                } else {
                    $message = "Failed to create order.";
                    renderView("view/check_out.php", ['message' => $message, 'carts' => $carts], "Create Order");
                }
            } else {
                $message = "Please fill in all required fields.";
                renderView("view/check_out.php", ['message' => $message, 'carts' => $carts], "Create Order");
            }
        } else {
            renderView("view/check_out.php", ['carts' => $carts], "Create Order");
        }
    }


    public function delete($id)
    {
        $isDeleted = $this->orderModel->deleteOrder($id);

        if ($isDeleted) {
            renderView("view/admin/order/success.php", ['message' => 'Order deleted successfully!'], "Success", 'admin');
        } else {
            renderView("view/admin/order/error.php", ['message' => 'Failed to delete order.'], "Error", 'admin');
        }
    }
}
