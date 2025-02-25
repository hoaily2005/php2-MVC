<?php
require_once "view/helpers.php";
require_once "model/CategoryModel.php";
require_once "model/ProductModel.php";
require_once 'core/BladeServiceProvider.php';


class Controller
{
    private $categoryModel;
    private $productModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
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
        BladeServiceProvider::render('admin/index', compact('category', 'products'), 'Admin', 'admin');
    }
}