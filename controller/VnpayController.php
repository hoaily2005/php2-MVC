<?php
require_once "./env.php";
require_once "./model/OrderModel.php";
require_once './model/CartModel.php';
require_once "./mail/mailler.php";
require_once "./view/helpers.php";
require_once 'core/BladeServiceProvider.php';


class VnPayController
{
    private $vnp_TmnCode;
    private $vnp_HashSecret;
    private $vnp_Url;
    private $vnp_Returnurl;
    private $orderModel;
    private $cartModel;
    private $mail;


    public function __construct()
    {
        $this->vnp_TmnCode = $_ENV['VNPAY_TMN_CODE'];
        $this->vnp_HashSecret = $_ENV['VNPAY_HASH_SECRET'];
        $this->vnp_Url = $_ENV['VNPAY_URL'];
        $this->vnp_Returnurl = $_ENV['VNPAY_RETURN_URL'];
        $this->orderModel = new OrderModel();
        $this->cartModel = new CartModel();
        $this->mail = new Mailer();
    }

    public function createPayment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = time();
            $order_amount = $_POST['total_price'];

            $vnp_Params = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $this->vnp_TmnCode,
                "vnp_Amount" => $order_amount * 100,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
                "vnp_Locale" => "vn",
                "vnp_OrderInfo" => "Thanh toan don hang #$order_id",
                "vnp_OrderType" => "billpayment",
                "vnp_ReturnUrl" => $this->vnp_Returnurl,
                "vnp_TxnRef" => $order_id
            );

            ksort($vnp_Params);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($vnp_Params as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&';
                    $query .= '&';
                }
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $query .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }

            $vnp_SecureHash = hash_hmac('sha512', $hashdata, $this->vnp_HashSecret);
            $query .= '&vnp_SecureHash=' . $vnp_SecureHash;

            $paymentUrl = $this->vnp_Url . "?" . $query;
            header('Location: ' . $paymentUrl);
            exit;
        }
    }

    public function vnpayReturn()
    {
        if (!isset($_GET['vnp_SecureHash']) || !isset($_GET['vnp_ResponseCode'])) {
            echo "Thiếu thông tin cần thiết từ VNPAY!";
            return;
        }

        $inputData = $_GET;
        $secureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);

        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . "=" . urlencode($value) . "&";
        }
        $hashData = rtrim($hashData, "&");
        $checkSum = hash_hmac('sha512', $hashData, $this->vnp_HashSecret);

        if ($checkSum === $secureHash) {
            if ($inputData['vnp_ResponseCode'] == '00') {
                $amount = $inputData['vnp_Amount'] / 100;
                $order_id = $inputData['vnp_TxnRef'];

                if (isset($_SESSION['order_info'])) {
                    $user_id = $_SESSION['order_info']['user_id'];
                    $payment_method = "vnpay";
                    $payment_status = "completed";
                    $shipping_address = $_SESSION['order_info']['shipping_address'];
                    $email = $_SESSION['order_info']['email'];
                    $phone = $_SESSION['order_info']['phone'];
                    $name = $_SESSION['order_info']['name'];

                    $isCreated = $this->orderModel->createOrder($user_id, $payment_method, $payment_status, $shipping_address, $amount, $email, $phone, $name);

                    if ($isCreated) {
                        $order_id = $this->orderModel->getLastInsertId();

                        if (isset($_SESSION['order_items']) && !empty($_SESSION['order_items'])) {
                            $order_items = $_SESSION['order_items'];
                            foreach ($order_items as $item) {
                                $sku = $item['sku'];
                                $price = $item['price'];
                                $quantity = $item['quantity'];
                                $this->orderModel->addOrderItem($order_id, $sku, $price, $quantity);
                            }

                            $this->cartModel->clearCart($user_id, session_id());
                            unset($_SESSION['order_items']);

                            $this->mail->sendMailSuccess($email, $name, $order_id, $amount);

                            // Gửi email chi tiết nếu cần
                            // $this->mail->sendMail($email, $emailSubject, $emailBody);

                            BladeServiceProvider::render("order_success", [
                                'message' => 'Giao dịch thành công!',
                                'order_id' => $order_id,
                                'total_price' => $amount
                            ], "Order Success");
                        } else {
                            BladeServiceProvider::render("order_errors", [
                                'message' => 'Không tìm thấy thông tin sản phẩm trong giỏ hàng.'
                            ], "Order Error");
                        }
                    } else {
                        BladeServiceProvider::render("order_errors", [
                            'message' => 'Không thể lưu đơn hàng vào cơ sở dữ liệu.'
                        ], "Order Error");
                    }
                } else {
                    BladeServiceProvider::render("order_errors", [
                        'message' => 'Không tìm thấy thông tin đơn hàng.'
                    ], "Order Error");
                }
            } else {
                BladeServiceProvider::render("order_errors", [
                    'message' => 'Giao dịch không thành công.'
                ], "Order Error");
            }
        } else {
            BladeServiceProvider::render("order_errors", [
                'message' => 'Chữ ký không hợp lệ!'
            ], "Order Error");
        }
    }
}
