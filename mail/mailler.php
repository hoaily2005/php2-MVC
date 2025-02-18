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
}
