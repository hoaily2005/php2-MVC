<?php
require_once "view/helpers.php";
require_once "model/CategoryModel.php";
require_once "model/ProductModel.php";
require_once "model/OrderModel.php";
require_once "model/RatingModel.php";
require_once 'core/BladeServiceProvider.php';


class Controller
{
    private $categoryModel;
    private $productModel;
    private $orderModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
    }
    public function index()
    {
        $category = $this->categoryModel->getAllcategories();
        $products = $this->productModel->getAllProducts();
        
        BladeServiceProvider::render('index', compact('category', 'products'), 'Home');
    }

    public function admin()
    {
        $category = $this->categoryModel->getAllcategories();
        $products = $this->productModel->getAllProducts();

        $bestSellingProducts = $this->productModel->getBestSellingProducts();
        $leastSellingProducts = $this->productModel->getLeastSellingProducts();

        $earningsForYear = $this->orderModel->getEarningsForYear();

        $successfulOrders = $this->orderModel->getSuccessfulOrders();
        $failedOrders = $this->orderModel->getFailedOrders();

        $months = [];
        $earnings = [];
        foreach ($earningsForYear as $data) {
            $months[] = $data['month'];
            $earnings[] = $data['total_revenue'];
        }

        BladeServiceProvider::render('admin/index', compact(
            'category',
            'products',
            'bestSellingProducts',
            'leastSellingProducts',
            'months',
            'earnings',
            'successfulOrders',  
            'failedOrders'       
        ), 'Admin', 'admin');
    }
}
