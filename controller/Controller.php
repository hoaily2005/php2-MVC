<?php
require_once "view/helpers.php";
require_once "model/ProductModel.php";
class Controller
{
    public function index()
    {
        $poroductController = new ProductController();
        $poroductController->indexHome();
    }
}
