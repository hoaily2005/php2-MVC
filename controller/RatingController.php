<?php

require_once 'model/RatingModel.php';
require_once 'model/ProductModel.php';
require_once 'model/UserModel.php';
require_once 'view/helpers.php';
require_once 'core/BladeServiceProvider.php';

class RatingController
{
    private $ratingModel;
    private $productModel;

    public function __construct()
    {
        $this->ratingModel = new RatingModel();
        $this->productModel = new ProductModel();
    }


    public function addRating()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['users']['id'])) {
                $_SESSION['error'] = "Bạn cần đăng nhập để đánh giá sản phẩm.";
                header("Location: /products/detail/{$_POST['product_id']}");
                exit;
            }

            $product_id = $_POST['product_id'] ?? null;
            $user_id = $_SESSION['users']['id'];
            $rating = $_POST['rating'] ?? null;
            $comment = $_POST['comment'] ?? null;

            if (empty($product_id) || empty($rating) || empty($user_id)) {
                $_SESSION['error'] = "Thiếu thông tin đánh giá!";
                header("Location: /products/detail/$product_id");
                exit;
            }

            $product = $this->productModel->getProductById($product_id);
            if (!$product) {
                $_SESSION['error'] = "Sản phẩm không tồn tại!";
                header("Location: /products");
                exit;
            }

            if ($this->ratingModel->hasRated($product_id, $user_id)) {
                $_SESSION['error'] = "Bạn đã đánh giá sản phẩm này rồi!";
                header("Location: /products/detail/$product_id");
                exit;
            }

            if ($this->ratingModel->addRating($product_id, $user_id, $rating, $comment)) {
                $_SESSION['success'] = "Đánh giá của bạn đã được ghi nhận!";
                header("Location: /products/detail/$product_id");
                exit;
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi thêm đánh giá!";
                header("Location: /products/detail/$product_id");
                exit;
            }
        } else {
            $_SESSION['error'] = "Yêu cầu không hợp lệ!";
            header("Location: /products");
            exit;
        }
    }
    public function getRatingsByProduct($product_id)
    {
        return $this->ratingModel->getRatingsByProduct($product_id);
    }

    public function getAverageRating($product_id)
    {
        return $this->ratingModel->getAverageRating($product_id);
    }

    
}
