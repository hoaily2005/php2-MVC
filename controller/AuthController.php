<?php
require_once "model/UserModel.php";
require_once "view/helpers.php";
session_start();

class AuthController
{
    private $UserModel;

    public function __construct()
    {
        $this->UserModel = new UserModel();
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
                $_SESSION['register_error'] = 'Vui lòng điền đầy đủ t   hông tin.';
                header('Location: /register');
                exit();
            }

            if ($password !== $confirm_password) {
                $_SESSION['register_error'] = 'Mật khẩu xác nhận không khớp.';
                header('Location: /register');
                exit();
            }

            $result = $this->UserModel->register($name, $email, $password, $phone);
            if ($result) {
                $_SESSION['register_success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
                header('Location: /login');
                exit();
            } else {
                $_SESSION['register_error'] = 'Đăng ký thất bại. Email có thể đã tồn tại.';
                header('Location: /register');
                exit();
            }
        } else {
            renderView('view/auth/register.php', [], 'Register');
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $user = $this->UserModel->login($email, $password);
            if ($user) {
                $role = $this->UserModel->getUserRoleByEmail($email);
                
                $_SESSION['users'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'phone' => $user['phone'],
                    'role' => $role
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

    public function unauthorized() {
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
