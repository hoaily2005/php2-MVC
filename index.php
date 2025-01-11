<?php
require_once "controller/ProductController.php";
require_once "controller/UserController.php";
require_once "controller/CategoryController.php";
require_once "controller/Controller.php";
require_once "router/Router.php";
$router = new Router();
$productController = new ProductController();
$userController = new UserController();
$categoryController = new CategoryController();
$controller = new Controller();

$router->addRoute("/products", [$productController, "index"]);
$router->addRoute("/products/create", [$productController, "create"]);
$router->addRoute("/products/{id}", [$productController, "show"]);
$router->addRoute("/products/edit/{id}", [$productController, "edit"]);
$router->addRoute("/products/delete/{id}", [$productController, "delete"]);

$router->addRoute("/users", [$userController, "index"]);
$router->addRoute("/register", [$userController, "create"]);
$router->addRoute("/users/edit/{id}", [$userController, "edit"]);
$router->addRoute("/users/delete/{id}", [$userController, "delete"]);
$router->addRoute("/login", [$userController, "login"]);

$router->addRoute("/category", [$categoryController, "index"]);
$router->addRoute("/category/create", [$categoryController, "create"]);
$router->addRoute("/category/edit/{id}", [$categoryController, "edit"]);
$router->addRoute("/category/delete/{id}", [$categoryController, "delete"]);

$router->addRoute("/", [$controller, "index"]);

$router->dispatch();
?>