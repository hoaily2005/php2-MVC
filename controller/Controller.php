<?php
require_once "view/helpers.php";
require_once "model/CategoryModel.php";
require_once "model/ProductModel.php";

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
        renderView('view/index.php', compact('category', 'products'), 'Home');
    }

    public function admin()
    {
        $category = $this->categoryModel->getAllcategories();
        $products = $this->productModel->getAllProducts();
        renderView('view/admin/index.php', compact('category', 'products'), 'Admin', 'admin');
    }
}