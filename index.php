<?php
require_once "controller/ProductController.php";
require_once "controller/CategoryController.php";
require_once "controller/Controller.php";
require_once "controller/AuthController.php";
require_once "controller/SizeController.php";
require_once "controller/ColorController.php";
require_once "router/Router.php";
require_once "middleware.php";

$router = new Router();
$productController = new ProductController();
$categoryController = new CategoryController();
$authController = new AuthController();
$sizeController = new SizeController();
$colorController = new ColorController();
$controller = new Controller();

$router->addMiddleware('logRequest');
//product
$router->addRoute("/products", [$productController, "index"], ['checkLogin', 'checkUserOrAdmin']);
$router->addRoute("/products/detail/{id}", [$productController, "show"], ['checkLogin', 'checkUserOrAdmin']);
$router->addRoute("/products/create", [$productController, "create"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/products/edit/{id}", [$productController, "edit"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/products/delete/{id}", [$productController, "delete"], ['checkLogin', 'checkAdmin']);

$router->addRoute("/users", [$authController, "indexUser"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/users/delete/{id}", [$authController, "delete"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/users/edit/{id}", [$authController, "editRole"], ['checkLogin', 'checkAdmin']);

//category
$router->addRoute("/category", [$categoryController, "index"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/category/create", [$categoryController, "create"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/category/edit/{id}", [$categoryController, "edit"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/category/delete/{id}", [$categoryController, "delete"], ['checkLogin', 'checkAdmin']);

//usser
$router->addRoute("/login", [$authController, "login"]);
$router->addRoute("/register", [$authController, "register"]);
$router->addRoute("/logout", [$authController, "logout"]);
$router->addRoute("/", [$controller, "index"]);
$router->addRoute("/login/google", [$authController, "redirectToGoogle"]);
$router->addRoute("/auth/google-login", [$authController, "googleCallback"]);

//forgot password
$router->addRoute("/forgot-password", [$authController, "forgotPassword"]);
$router->addRoute("/reset-password", [$authController, "resetPassword"]);

//size
$router->addRoute("/sizes", [$sizeController, "index"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/sizes/create", [$sizeController, "create"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/sizes/edit/{id}", [$sizeController, "edit"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/sizes/delete/{id}", [$sizeController, "delete"], ['checkLogin', 'checkAdmin']);

//color
$router->addRoute("/colors", [$colorController, "index"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/colors/create", [$colorController, "create"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/colors/edit/{id}", [$colorController, "edit"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/colors/delete/{id}", [$colorController, "delete"], ['checkLogin', 'checkAdmin']);

$router->addRoute("/unauthorized", [$authController, "unauthorized"]);

$router->dispatch();
?>