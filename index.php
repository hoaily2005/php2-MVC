<?php
require_once "controller/ProductController.php";
require_once "controller/CategoryController.php";
require_once "controller/Controller.php";
require_once "controller/AuthController.php";
require_once "router/Router.php";
require_once "middleware.php";

$router = new Router();
$productController = new ProductController();
$categoryController = new CategoryController();
$authController = new AuthController();
$controller = new Controller();

$router->addMiddleware('logRequest');

$router->addRoute("/products", [$productController, "index"], ['checkLogin', 'checkUserOrAdmin']);
$router->addRoute("/products/detail/{id}", [$productController, "show"], ['checkLogin', 'checkUserOrAdmin']);

$router->addRoute("/products/create", [$productController, "create"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/products/edit/{id}", [$productController, "edit"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/products/delete/{id}", [$productController, "delete"], ['checkLogin', 'checkAdmin']);

$router->addRoute("/category", [$categoryController, "index"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/category/create", [$categoryController, "create"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/category/edit/{id}", [$categoryController, "edit"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/category/delete/{id}", [$categoryController, "delete"], ['checkLogin', 'checkAdmin']);

$router->addRoute("/login", [$authController, "login"]);
$router->addRoute("/register", [$authController, "register"]);
$router->addRoute("/logout", [$authController, "logout"]);
$router->addRoute("/", [$controller, "index"]);
$router->addRoute("/unauthorized", [$authController, "unauthorized"]);

$router->dispatch();
?>