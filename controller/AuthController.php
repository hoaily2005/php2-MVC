<?php
require_once "model/UserModel.php";
require_once "model/AddressModel.php";
require_once "mail/mailler.php";
require_once "view/helpers.php";
require_once './vendor/autoload.php';
require_once './env.php';
require_once 'core/BladeServiceProvider.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class AuthController
{
    private $UserModel;
    private $googleClient;
    private $addressModel;

    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->addressModel = new AddressModel();

        $this->googleClient = new Google_Client();
        $this->googleClient->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $this->googleClient->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $this->googleClient->setRedirectUri($_ENV['GOOGLE_REDIRECT_URL']);
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
            BladeServiceProvider::render('auth/forgot', [], 'Forgot Password');
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
            BladeServiceProvider::render('auth/resetpass', [], 'Reset Password');
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
            BladeServiceProvider::render('auth/register', [], 'Register');
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
            BladeServiceProvider::render('auth/login', [], 'Login');
        }
    }


    public function unauthorized()
    {
        BladeServiceProvider::render('unauthorized', [], 'Unauthorized Access');
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login');
        exit();
    }
    public function indexUser()
    {
        $users = $this->UserModel->getAllUsers();
        BladeServiceProvider::render("admin/user/index", compact('users'), "User List", 'admin');
    }

    public function show($id)
    {
        // Get user details
        $user = $this->UserModel->getUserById($id);
        
        if (!$user) {
            $_SESSION['error'] = "Không tìm thấy người dùng.";
            header('Location: /');
            exit;
        }

        // Get all addresses for this user
        $addresses = $this->addressModel->getAllAddress($id);

        // Render the Blade template with user and addresses
        BladeServiceProvider::render("profile/index", compact('user', 'addresses'), "User Details");
    }


    public function delete($id)
    {
        $user = $this->UserModel->getUserById($id);

        if (!$user) {
            $_SESSION['error'] = "Người dùng không tồn tại!";
            header("Location: /admin/users");
            exit;
        }

        if ($user['role'] === 'admin') {
            $_SESSION['error'] = "Không thể xóa tài khoản quản trị viên!";
            header("Location: /admin/users");
            exit;
        }

        if ($this->UserModel->deleteUser($id)) {
            $_SESSION['success'] = "Xóa user thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa user!";
        }

        header("Location: /admin/users");
        exit;
    }
    public function editRole($id)
    {
        $user = $this->UserModel->getUserById($id);

        if (!$user) {
            $_SESSION['error'] = "Người dùng không tồn tại!";
            header("Location: /admin/users");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = $_POST['role'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            if (!in_array($role, ['user', 'admin'])) {
                $_SESSION['error'] = "Vai trò không hợp lệ!";
                header("Location: /user/edit/$id");
                exit;
            }
            if ($this->UserModel->updateRole($id, $role, $name, $phone)) {
                $_SESSION['success'] = "Cập nhật vai trò thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật!";
            }

            header("Location: /admin/users");
            exit;
        }
        BladeServiceProvider::render("admin/user/edit", compact('user'), "Edit Role", 'admin');
    }


    public function updateProfile($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];

            $result = $this->UserModel->updateProfile($id, $name, $phone);

            if ($result) {
                $_SESSION['success'] = "Cập nhật thông tin thành công!";
            } else {
                $_SESSION['error'] = "Lỗi, không thể cập nhật thông tin!";
            }

            header('Location: /profile/' . $id);
            exit();
        } else {
            header('Location: /profile/' . $id);
            exit();
        }
    }
}
