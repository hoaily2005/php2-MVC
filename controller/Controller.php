<?php
require_once "view/helpers.php";
require_once "controller/ProductController.php";

class Controller
{
    public function index()
    {
        $productController = new ProductController();
        $productController->indexHome();
    }
}