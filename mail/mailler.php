<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

class Mailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = 'lyxuanhoai18@gmail.com'; 
        $this->mail->Password   = 'gfvdhmnezybhsbql';      
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = 587;
        $this->mail->setFrom('lyxuanhoai18@gmail.com', 'ADMIN SHOP');
    }

    public function sendMail($to, $subject, $message)
    {
        try {
            $this->mail->addAddress($to); 
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
