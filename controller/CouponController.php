<?php

require_once 'model/CouponModel.php';
require_once 'view/helpers.php';
require_once 'core/BladeServiceProvider.php';

class CouponController
{
    private $couponModel;

    public function __construct()
    {
        $this->couponModel = new CouponModel();
    }

    public function index()
    {
        $title = "Danh sách mã giảm giá";
        $coupons = $this->couponModel->getAllCoupons();
        BladeServiceProvider::render("admin/coupons/index", compact('coupons', 'title'), "Danh sách mã giảm giá", 'admin');
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'];
            $discount = (int)$_POST['discount'];
            $discount_type = $_POST['discount_type'];
            $expiry_date = $_POST['expiry_date'];
            $usage_limit = (int)$_POST['usage_limit'];

            $errors = $this->validateCoupon(['code' => $code, 'discount' => $discount, 'expiry_date' => $expiry_date, 'usage_limit' => $usage_limit]);

            if (empty($errors)) {
                $this->couponModel->createCoupon($code, $discount, $discount_type, $expiry_date, $usage_limit);
                $_SESSION['success'] = "Thêm mã giảm giá thành công!";
                header("Location: /admin/coupons");
                exit;
            } else {
                BladeServiceProvider::render("admin/coupons/create", compact('errors', 'code', 'discount', 'discount_type', 'expiry_date', 'usage_limit'), "Create Coupon", 'admin');
            }
        } else {
            BladeServiceProvider::render("admin/coupons/create", ['title' => "Create Coupon"], "Create Coupon", 'admin');
        }
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'];
            $discount = (int)$_POST['discount'];
            $discount_type = $_POST['discount_type'];
            $expiry_date = $_POST['expiry_date'];
            $usage_limit = (int)$_POST['usage_limit'];

            $errors = $this->validateCoupon(['code' => $code, 'discount' => $discount, 'expiry_date' => $expiry_date, 'usage_limit' => $usage_limit]);

            if (empty($errors)) {
                $this->couponModel->updateCoupon($id, $code, $discount, $discount_type, $expiry_date, $usage_limit);
                $_SESSION['success'] = "Cập nhật mã giảm giá thành công!";
                header("Location: /admin/coupons");
                exit;
            } else {
                BladeServiceProvider::render("admin/coupons/edit", compact('errors', 'id', 'code', 'discount', 'discount_type', 'expiry_date', 'usage_limit'), "Edit Coupon", 'admin');
            }
        } else {
            $coupon = $this->couponModel->getCouponById($id);
            BladeServiceProvider::render("admin/coupons/edit", compact('coupon'), "Edit Coupon", 'admin');
        }
    }

    public function delete($id)
    {
        $this->couponModel->deleteCoupon($id);
        $_SESSION['success'] = "Xóa mã giảm giá thành công!";
        header("Location: /admin/coupons");
        exit;
    }

    private function validateCoupon($coupon)
    {
        $errors = [];
        if (empty($coupon['code'])) {
            $errors['code'] = "Mã giảm giá không được để trống";
        }
        if ($coupon['discount'] <= 0) {
            $errors['discount'] = "Giá trị giảm phải lớn hơn 0";
        }
        if (empty($coupon['expiry_date'])) {
            $errors['expiry_date'] = "Ngày hết hạn không được để trống";
        }
        if ($coupon['usage_limit'] <= 0) {
            $errors['usage_limit'] = "Giới hạn sử dụng phải lớn hơn 0";
        }
        return $errors;
    }
}
