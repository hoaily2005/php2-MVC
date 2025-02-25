<?php

use Illuminate\Support\Facades\Blade;

require_once "model/CategoryModel.php";
require_once "model/UserModel.php";
require_once "model/ProductVariantModel.php";
require_once "model/CartModel.php";
require_once "view/helpers.php";
require_once "model/OrderModel.php";
require_once 'core/BladeServiceProvider.php';
require_once "mail/mailler.php";


class OrderController
{
    private $orderModel;
    private $cartModel;
    private $variantModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->cartModel = new CartModel();
        $this->variantModel = new ProductVariantModel();
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
        $title = "orders List";
        $orders = $this->orderModel->getAllOrders();
        BladeServiceProvider::render("order/admin", compact('orders', 'title'), 'admin');
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
            $email = $_POST['email'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $name = $_POST['name'] ?? null;

            $_SESSION['order_info'] = [
                'user_id' => $user_id,
                'payment_method' => $payment_method,
                'payment_status' => $payment_status,
                'shipping_address' => $shipping_address,
                'total_price' => $total_price,
                'email' => $email,
                'phone' => $phone,
                'name' => $name
            ];

            if ($user_id && $payment_method && $shipping_address && $total_price > 0) {
                if ($payment_method == "cod") {
                    $isCreated = $this->orderModel->createOrder($user_id, $payment_method, $payment_status, $shipping_address, $total_price, $email, $phone, $name);
                    if ($isCreated) {
                        $order_id = $this->orderModel->getLastInsertId();

                        foreach ($carts as $cart) {
                            $this->orderModel->addOrderItem($order_id, $cart['sku'], $cart['price'], $cart['quantity']);
                        }

                        $this->cartModel->clearCart($user_id);

                        $message = "Đơn hàng đã được tạo thành công!";
                        BladeServiceProvider::render("order_success", ['message' => $message], "Order Success");
                    } else {
                        $message = "Không thể tạo đơn hàng.";
                        BladeServiceProvider::render("checkout/check_out", ['message' => $message, 'carts' => $carts], "Create Order");
                    }
                } elseif ($payment_method == "vnpay") {
                    foreach ($carts as $cart) {
                        $_SESSION['order_items'] = $carts;
                        $product_variant_id = $cart['product_variant_id'];
                        $quantity = $cart['quantity'];

                        echo '<form id="vnpayForm" action="/vnpay" method="POST">';
                        echo '<input type="hidden" name="total_price" value="' . $total_price . '">';
                        echo '<input type="hidden" name="name" value="' . $name . '">';
                        echo '<input type="hidden" name="email" value="' . $email . '">';
                        echo '<input type="hidden" name="phone" value="' . $phone . '">';
                        echo '<input type="hidden" name="shipping_address" value="' . $shipping_address . '">';
                        echo '</form>';
                        echo '<script>document.getElementById("vnpayForm").submit();</script>';
                        $this->variantModel->decreaseStock($product_variant_id, $quantity);
                    }
                } elseif ($payment_method == "momo") {
                    echo '<form id="momoForm" action="/payment/momo/create" method="POST">';
                    echo '<input type="hidden" name="amount" value="' . $total_price . '">';
                    echo '</form>';
                    echo '<script>document.getElementById("momoForm").submit();</script>';
                }
            } else {
                $message = "Vui lòng điền đầy đủ thông tin!";
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
                if ($payment_status == 'completed') {
                    $orderItems = $this->orderModel->getOrderItems($order_id);

                    foreach ($orderItems as $orderItem) {
                        $variantId = $orderItem['product_variant_id'];
                        $quantity = $orderItem['quantity'];

                        $isQuantityUpdated = $this->variantModel->checkQuantity($variantId, $quantity);

                        if (!$isQuantityUpdated) {
                            $_SESSION['error'] = "Không đủ số lượng hàng để hoàn thành đơn hàng.";
                            header("Location: /admin/orders");
                            exit();
                        }
                    }
                } elseif ($payment_status == 'failed') {
                    $orderItems = $this->orderModel->getOrderItems($order_id);

                    foreach ($orderItems as $orderItem) {
                        $variantId = $orderItem['product_variant_id'];
                        $quantity = $orderItem['quantity'];

                        $this->variantModel->increaseQuantity($variantId, $quantity);
                    }

                    $_SESSION['success'] = "Đơn hàng đã bị hủy và số lượng đã được hoàn lại vào kho.";
                }

                $customer_email = $this->orderModel->getUserEmail($order_id);

                if ($customer_email) {
                    $mailer = new Mailer();
                    $subject = "Cập nhật trạng thái đơn hàng #" . $order_id;
                    $message = "Chào bạn, \n\nTrạng thái đơn hàng của bạn đã được cập nhật thành: " . $payment_status . ".\nCảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!";
                    $emailResult = $mailer->sendMail($customer_email, $subject, $message);

                    if ($emailResult['status']) {
                        $_SESSION['success'] = "Cập nhật trạng thái thành công và đã gửi email thông báo.";
                    } else {
                        $_SESSION['error'] = "Cập nhật trạng thái thành công nhưng không thể gửi email: " . $emailResult['message'];
                    }
                } else {
                    $_SESSION['error'] = "Không tìm thấy email người dùng.";
                }

                header("Location: /admin/orders");
                exit();
            } else {
                echo "Lỗi không thể cập nhập trạng thái.";
            }
        }
    }

    public function trackOrder()
    {
        $order_id = $_GET['order_id'] ?? null;

        if ($order_id) {
            $order = $this->orderModel->getOrderById($order_id);

            if ($order) {
                BladeServiceProvider::render("/tracking", compact('order'), "Tracking Order");
            } else {
                BladeServiceProvider::render("/tracking", ['message' => 'Không tìm thấy đơn hàng với mã: ' . $order_id], "Error");
            }
        } else {
            BladeServiceProvider::render("/tracking", ['message' => 'Vui lòng nhập mã đơn hàng để tra cứu.'], "Error");
        }
    }
}
