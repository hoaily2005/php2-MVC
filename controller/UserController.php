<?php
require_once "model/UserModel.php";
require_once "view/helpers.php";

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel->getAllUsers();
        renderView("view/user_list.php", compact('users'), "User List");
    }
    public function show($id)
    {
        $user = $this->userModel->getUserById($id);
        renderView("view/user_detail.php", compact('user'), "User Detail");
    }
    public function delete($id)
    {
        $this->userModel->deleteUser($id);
        header("Location: /users");
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $role = $_POST['role'] ?? 'user';

            $errors = $this->validateUser(['name' => $name, 'email' => $email, 'password' => $password, 'phone' => $phone, 'address' => $address]);
            if (empty($errors)) {
                $this->userModel->createUser($name, $email, $password, $phone, $address);
                header("Location: /users");
                exit;
            } else {
                renderView("view/register.php", compact('errors', 'name', 'email', 'password', 'phone', 'address'), "Create User");
            }

            // $this->userModel->createUser($name, $email, $password, $phone, $address, $role);
            // header("Location: /users");
        } else {
            renderView("view/register.php", [], "Create User");
        }
    }

    //dang nhap
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
            if (!preg_match($regex, $email)) {
                $errors['email'] = 'Invalid email format';
            } else if (empty($email)) {
                $errors['email'] = 'Email is required';
            }

            if (empty($password)) {
                $errors['password'] = 'Password is required';
            }

            if (!empty($errors)) {
                renderView("view/login.php", compact('errors'), "Login User");
            } else {
                $user = $this->userModel->getLogin($email, $password);
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    header("Location: /");
                } else {
                    $errors['login'] = 'Invalid email or password';
                    renderView("view/login.php", compact('errors'), "Login User");
                }
            }
        } else {
            renderView("view/login.php", [], "Login User");
        }
    }


    public function edit($id)
    {
        $user = $this->userModel->getUserById($id);

        if (!$user) {
            die("Người dùng không tồn tại!");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = $_POST['role'] ?? '';
            $validRoles = ['user', 'admin'];

            if (!in_array($role, $validRoles)) {
                $error = "Vai trò không hợp lệ!";
                renderView("view/user_edit.php", compact('user', 'error'), "Edit User");
                return;
            }

            $this->userModel->updateUser($id, ['role' => $role]);

            header("Location: /users");
            exit;
        }

        renderView("view/user_edit.php", compact('user'), "Edit User");
    }

    private function validateUser($user)
    {
        $errors = [];
        if (empty($user['name'])) {
            $errors['name'] = "Vui lòng nhập tên";
        }
        if (empty($user['email'])) {
            $errors['email'] = "Vui lòng nhập email";
        }
        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không hợp lệ";
        }
        if (empty($user['password'])) {
            $errors['password'] = "Vui lòng nhập mật khẩu";
        }
        if (empty($user['phone'])) {
            $errors['phone'] = "Vui lòng nhập số điện thoại";
        }
        if (empty($user['address'])) {
            $errors['address'] = "Vui lòng nhập địa chỉ";
        }
        return $errors;
    }
}
