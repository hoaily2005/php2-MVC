<?php
// Start session for error/success messages (optional, can be moved to index.php)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "model/AddressModel.php";
require_once "view/helpers.php";
require_once 'core/BladeServiceProvider.php';

class AddressController
{
    private $addressModel;

    public function __construct()
    {
        $this->addressModel = new AddressModel();
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
                $_SESSION['error'] = "Không tìm thấy ID người dùng.";
                header('Location: /profile/address');
                exit;
            }

            $user_id = $_POST['user_id'];
            $full_name = $_POST['full_name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';

            if (empty($full_name) || empty($phone) || empty($address)) {
                $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin.";
                header('Location: /profile/address');
                exit;
            }

            if ($this->addressModel->create($user_id, $full_name, $phone, $address)) {
                $_SESSION['success'] = "Địa chỉ đã được thêm thành công!";
                header('Location: /profile/{$user_id}');
            } else {
                $_SESSION['error'] = "Có lỗi khi thêm địa chỉ.";
                header('Location: /profile/{$user_id}');
            }
            exit;
        }
    }

    public function updateAddress($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = $_POST['full_name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            if ($this->addressModel->update($id, $full_name, $phone, $address)) {
                header('Location: /profile#address');
            } else {
                $_SESSION['error'] = "Có lỗi khi cập nhật địa chỉ.";
                header('Location: /profile#address');
            }
            exit;
        }
    }
}