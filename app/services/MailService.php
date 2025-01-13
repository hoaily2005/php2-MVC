<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class MailService
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        try {
            // Cấu hình SMTP
            $this->mail->isSMTP();
            $this->mail->Host       = 'smtp.gmail.com'; 
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = 'lyxuanhoai18@gmail.com'; 
            $this->mail->Password   = 'gfvdhmnezybhsbql
';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port       = 587;
            $this->mail->CharSet    = 'UTF-8';
        } catch (Exception $e) {
            echo "Lỗi SMTP: {$this->mail->ErrorInfo}";
        }
    }

    public function sendMail($toEmail, $toName, $subject, $body)
    {
        try {
            $this->mail->setFrom('lyxuanhoai18@gmail.com', 'ĐỔI MẬT KHẨU');
            $this->mail->addAddress($toEmail, $toName);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;

            return $this->mail->send();
        } catch (Exception $e) {
            return "Lỗi gửi mail: {$this->mail->ErrorInfo}";
        }
    }
}
