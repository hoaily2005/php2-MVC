<?php
require_once "model/UserModel.php";
require_once "mail/mailler.php";
require_once "view/helpers.php";
require_once "vendor/autoload.php";


class AuthController
{
    private $UserModel;
    private $googleClient;

    public function __construct()
    {
        $this->UserModel = new UserModel();

        $this->googleClient = new Google_Client();
        $this->googleClient->setClientId('NHAP-ID-CUA-BAN');
        $this->googleClient->setClientSecret('NHAP-MA-CUA-BAN');
        $this->googleClient->setRedirectUri('NHAP-LINK-CUA-BAN');
        $this->googleClient->addScope("email");
        $this->googleClient->addScope("profile");
    }

    public function redirectToGoogle()
    {
        $authUrl = $this->googleClient->createAuthUrl();
        header("Location: $authUrl");
        exit();
    }

    public function googleCallback()
    {
        if (!isset($_GET['code'])) {
            header('Location: /login');
            exit();
        }

        $token = $this->googleClient->fetchAccessTokenWithAuthCode($_GET['code']);
        $this->googleClient->setAccessToken($token);

        $googleService = new Google_Service_Oauth2($this->googleClient);
        $googleUser = $googleService->userinfo->get();

        $email = $googleUser->email;
        $name = $googleUser->name;

        $user = $this->UserModel->getUserByEmail($email);
        if (!$user) {
            $this->UserModel->registerGoogle($name, $email, null, null, 'google');
            $user = $this->UserModel->getUserByEmail($email);
        }

        $_SESSION['users'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'phone' => $user['phone'],
            'role' => $user['role'],
            'auth_provider' => 'google'
        ];
        $_SESSION['login_success'] = true;

        header('Location: /');
        exit();
    }
    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);

            if (!$email) {
                $_SESSION['forgot_error'] = 'Email không hợp lệ. Vui lòng nhập lại.';
                header('Location: /forgot-password');
                exit();
            }

            $user = $this->UserModel->getUserByEmail($email);

            if (!$user) {
                $_SESSION['forgot_error'] = 'Email không tồn tại trong hệ thống.';
                header('Location: /forgot-password');
                exit();
            }

            $token = bin2hex(random_bytes(32));

            $this->UserModel->savePasswordResetToken($email, $token);

            $resetLink = "http://localhost:8000/reset-password?token=" . $token;

            $emailSubject = "Yêu cầu đặt lại mật khẩu";
            $emailBody = "
                <div style='max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif;'>
                    <h2 style='color: #333; text-align: center;'>Yêu cầu đặt lại mật khẩu</h2>
                    <div style='background-color: #f8f9fa; padding: 20px; border-radius: 5px;'>
                        <p>Xin chào {$user['name']},</p>
                        <p>Vui lòng click vào link bên dưới để đặt lại mật khẩu:</p>
                        <p><a href='{$resetLink}' style='text-decoration: none; color: #007bff;'>Đặt lại mật khẩu</a></p>
                        <p>Link này sẽ hết hạn sau 1 giờ.</p>
                    </div>
                </div>
            ";

            $mailer = new Mailer();
            $result = $mailer->sendMail($email, $emailSubject, $emailBody);

            if ($result['status']) {
                $_SESSION['forgot_success'] = 'Link đặt lại mật khẩu đã được gửi tới email của bạn.';
                header('Location: /forgot-password');
                exit();
            } else {
                $_SESSION['forgot_error'] = 'Không thể gửi email. Vui lòng thử lại sau.';
                error_log($result['message']);
                header('Location: /forgot-password');
                exit();
            }
        } else {
            renderView('view/auth/forgot.php', [], 'Forgot Password');
        }
    }

    public function resetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($token) || empty($password) || empty($confirmPassword)) {
                $_SESSION['reset_error'] = 'Vui lòng nhập đầy đủ thông tin.';
                header('Location: /reset-password?token=' . $token);
                exit();
            }

            if ($password !== $confirmPassword) {
                $_SESSION['reset_error'] = 'Mật khẩu xác nhận không khớp.';
                header('Location: /reset-password?token=' . $token);
                exit();
            }

            $userModel = new UserModel();
            $user = $userModel->getUserByToken($token);

            if (!$user) {
                $_SESSION['reset_error'] = 'Token không hợp lệ hoặc đã hết hạn.';
                header('Location: /forgot-password');
                exit();
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $userModel->resetPassword($user['email'], $hashedPassword);

            $userModel->deletePasswordResetToken($user['email']);


            $_SESSION['reset_success'] = 'Mật khẩu đã được cập nhật. Bạn có thể đăng nhập ngay bây giờ.';
            header('Location: /login');
            exit();
        } else {
            renderView('view/auth/resetpass.php', [], 'Reset Password');
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);

            if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
                $_SESSION['register_error'] = 'Vui lòng điền đầy đủ thông tin.';
                header('Location: /register');
                exit();
            }

            if ($password !== $confirm_password) {
                $_SESSION['register_error'] = 'Mật khẩu xác nhận không khớp.';
                header('Location: /register');
                exit();
            }
            $existingUser = $this->UserModel->checkEmailExists($email);
            if ($existingUser) {
                $_SESSION['register_error'] = 'Email này đã được đăng ký.';
                header('Location: /register');
                exit();
            }

            $result = $this->UserModel->register($name, $email, $password, $phone);
            if ($result) {
                $_SESSION['register_success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
                header('Location: /login');
                exit();
            } else {
                $_SESSION['register_error'] = 'Đăng ký thất bại. Vui lòng thử lại.';
                header('Location: /register');
                exit();
            }
        } else {
            renderView('view/auth/register.php', [], 'Register');
        }
    }


    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->UserModel->login($email, $password);
            if ($user) {
                $_SESSION['users'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'phone' => $user['phone'],
                    'role' => $user['role']
                ];
                $_SESSION['login_success'] = true;

                header('Location: /');
                exit();
            } else {
                $_SESSION['login_failed'] = true;
                header('Location: /login');
                exit();
            }
        } else {
            renderView('view/auth/login.php', [], 'Login');
        }
    }


    public function unauthorized()
    {
        renderView('view/unauthorized.php', [], 'Unauthorized Access');
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login');
        exit();
    }
}
