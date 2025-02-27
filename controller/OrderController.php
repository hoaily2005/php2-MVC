<?php

use Illuminate\Support\Facades\Blade;

require_once "model/CategoryModel.php";
require_once "model/UserModel.php";
require_once "model/ProductVariantModel.php";
require_once "model/CartModel.php";
require_once "view/helpers.php";
require_once "model/OrderModel.php";
require_once "model/AddressModel.php";
require_once "model/CouponModel.php";
require_once 'core/BladeServiceProvider.php';
require_once "mail/mailler.php";


class OrderController
{
    private $orderModel;
    private $cartModel;
    private $variantModel;
    private $couponModel;
    private $addressModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->cartModel = new CartModel();
        $this->variantModel = new ProductVariantModel();
        $this->couponModel = new CouponModel();
        $this->addressModel = new AddressModel();
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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user_id = $_SESSION['users']['id'] ?? null;
        $cart_session = session_id();

        if (!$user_id) {
            $_SESSION['error'] = "Vui lòng đăng nhập để thanh toán.";
            header("Location: /login");
            exit();
        }

        $carts = $this->cartModel->getCart($user_id, $cart_session);
        $totalPrice = 0;
        foreach ($carts as $cart) {
            $totalPrice += $cart['price'] * $cart['quantity'];
        }

        $addresses = $this->addressModel->getAllAddress($user_id);
        $user = $_SESSION['users'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $coupon_code = $_POST['coupon_code'] ?? '';
            $discount = 0;
            $error = '';

            if (!empty($coupon_code)) {
                $coupon = $this->couponModel->getCoupon($coupon_code);
                if ($coupon) {
                    if (strtotime($coupon['expiry_date']) < time()) {
                        $error = "Mã giảm giá đã hết hạn!";
                    } elseif ($coupon['used_count'] >= $coupon['usage_limit']) {
                        $error = "Mã giảm giá đã hết lượt sử dụng!";
                    } else {
                        if ($coupon['discount_type'] == 'fixed') {
                            $discount = $coupon['discount'];
                        } elseif ($coupon['discount_type'] == 'percent') {
                            $discount = $totalPrice * ($coupon['discount'] / 100);
                        }
                    }
                } else {
                    $error = "Mã giảm giá không hợp lệ!";
                }
            }

            $totalPrice -= $discount;

            $payment_method = $_POST['payment_method'] ?? null;
            $payment_status = $_POST['payment_status'] ?? 'Pending';
            $address_id = $_POST['address_id'] ?? '';
            $email = $_POST['email'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $name = $_POST['name'] ?? null;

            if (empty($address_id)) {
                $shipping_address = $_POST['address'] ?? null;
                if (empty($name) || empty($phone) || empty($shipping_address)) {
                    $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin giao hàng.";
                    header('Location: /checkout');
                    exit;
                }
            } else {
                $selected_address = array_filter($addresses, fn($addr) => $addr['id'] == $address_id);
                $selected_address = reset($selected_address);
                if (!$selected_address) {
                    $_SESSION['error'] = "Địa chỉ không hợp lệ.";
                    header('Location: checkout/check_out');
                    exit;
                }
                $name = $selected_address['full_name'];
                $phone = $selected_address['phone'];
                $shipping_address = $selected_address['address'];
            }

            if ($payment_method && $shipping_address && $totalPrice > 0) {
                if ($payment_method == "cod") {
                    $isCreated = $this->orderModel->createOrder($user_id, $payment_method, $payment_status, $shipping_address, $totalPrice, $email, $phone, $name);
                    if ($isCreated) {
                        $order_id = $this->orderModel->getLastInsertId();
                        foreach ($carts as $cart) {
                            $this->orderModel->addOrderItem($order_id, $cart['sku'], $cart['price'], $cart['quantity']);
                        }
                        $this->cartModel->clearCart($user_id);
                        $message = "Đơn hàng đã được tạo thành công!";
                        BladeServiceProvider::render("order_success", ['message' => $message], "Order Success");
                    } else {
                        $_SESSION['error'] = "Không thể tạo đơn hàng.";
                        header('Location: checkout/check_out');
                    }
                } elseif ($payment_method == "vnpay") {
                    $_SESSION['order_info'] = [
                        'user_id' => $user_id,
                        'payment_method' => $payment_method,
                        'payment_status' => $payment_status,
                        'shipping_address' => $shipping_address,
                        'total_price' => $totalPrice,
                        'email' => $email,
                        'phone' => $phone,
                        'name' => $name,
                        'carts' => $carts
                    ];
                    echo '<form id="vnpayForm" action="/vnpay" method="POST">';
                    echo '<input type="hidden" name="total_price" value="' . $totalPrice . '">';
                    echo '<input type="hidden" name="name" value="' . htmlspecialchars($name) . '">';
                    echo '<input type="hidden" name="email" value="' . htmlspecialchars($email) . '">';
                    echo '<input type="hidden" name="phone" value="' . htmlspecialchars($phone) . '">';
                    echo '<input type="hidden" name="shipping_address" value="' . htmlspecialchars($shipping_address) . '">';
                    echo '</form>';
                    echo '<script>document.getElementById("vnpayForm").submit();</script>';
                } elseif ($payment_method == "momo") {
                    echo '<form id="momoForm" action="/payment/momo/create" method="POST">';
                    echo '<input type="hidden" name="amount" value="' . $totalPrice . '">';
                    echo '</form>';
                    echo '<script>document.getElementById("momoForm").submit();</script>';
                }
            } else {
                $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin!";
                header('Location: checkout/check_out');
            }
        } else {
            BladeServiceProvider::render("checkout/check_out", compact('carts', 'totalPrice', 'addresses', 'user'), "Checkout");
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
    public function process()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['id'];
            $payment_method = $_POST['payment_method'] ?? 'cod';
            $address_id = $_POST['address_id'] ?? '';

            if (empty($address_id)) {
                // Use manual input if no address is selected
                $full_name = $_POST['name'] ?? '';
                $phone = $_POST['phone'] ?? '';
                $address = $_POST['address'] ?? '';
                if (empty($full_name) || empty($phone) || empty($address)) {
                    $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin giao hàng.";
                    header('Location: /checkout');
                    exit;
                }
            } else {
                // Use selected address from database
                $addresses = $this->addressModel->getAllAddress($user_id);
                $selected_address = array_filter($addresses, fn($addr) => $addr['id'] == $address_id);
                $selected_address = reset($selected_address);
                if (!$selected_address) {
                    $_SESSION['error'] = "Địa chỉ không hợp lệ.";
                    header('Location: /checkout');
                    exit;
                }
                $full_name = $selected_address['full_name'];
                $phone = $selected_address['phone'];
                $address = $selected_address['address'];
            }

            // Process the order (e.g., save to database)
            // Example: $this->orderModel->create($user_id, $full_name, $phone, $address, $payment_method, $carts, $totalPrice);

            $_SESSION['success'] = "Đơn hàng đã được đặt thành công!";
            header('Location: /order/success');
            exit;
        }
    }
}
