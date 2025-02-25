<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';
require_once './env.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Mailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->Host       = $_ENV['MAIL_HOST'];
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $_ENV['MAIL_USERNAME'];
        $this->mail->Password   = $_ENV['MAIL_PASSWORD'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = $_ENV['MAIL_PORT'];
        $this->mail->setFrom('lyxuanhoai18@gmail.com', 'ADMIN SHOP');
    }

    public function sendMail($to, $subject, $message)
    {
        try {
            $this->mail->addAddress($to);
            $this->mail->CharSet = 'UTF-8';
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $message;


            if ($this->mail->send()) {
                return ["status" => true, "message" => "Email đã được gửi thành công!"];
            } else {
                return ["status" => false, "message" => "Gửi email thất bại: " . $this->mail->ErrorInfo];
            }
        } catch (Exception $e) {
            return ["status" => false, "message" => "Lỗi: " . $this->mail->ErrorInfo];
        }
    }
    public function sendMailSuccess($email, $name, $order_id, $amount)
    {
        try {
            $this->mail->isHTML(true);
            $this->mail->CharSet = 'UTF-8';
            $this->mail->addAddress($email);
            
            $subject = "Đơn hàng #$order_id - Thanh toán thành công";
            
            $message = "
            <div style='max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif;'>
                <h2 style='color: #333; text-align: center;'>Thanh toán thành công đơn hàng</h2>
                <div style='background-color: #f8f9fa; padding: 20px; border-radius: 5px;'>
                    <p>Xin chào $name,</p>
                    <p>Cảm ơn bạn đã mua hàng tại cửa hàng của chúng tôi. Đơn hàng của bạn đã được thanh toán thành công.</p>
                    <p><strong>Mã đơn hàng:</strong> #$order_id</p>
                    <p><strong>Tổng tiền:</strong> " . number_format($amount, 0, ',', '.') . "₫</p>
                    <p>Trân trọng, <br>ADMIN SHOP</p>
                </div>
            </div>
            ";
    
            return $this->sendMail($email, $subject, $message);
        } catch (Exception $e) {
            return ["status" => false, "message" => "Lỗi: " . $this->mail->ErrorInfo];
        }
    }
    
}
