<?php
require_once "controller/ProductController.php";
require_once "controller/CategoryController.php";
require_once "controller/Controller.php";
require_once "controller/AuthController.php";
require_once "controller/SizeController.php";
require_once "controller/ColorController.php";
require_once "controller/ProductVariantController.php";
require_once "controller/CartController.php";
require_once "controller/OrderController.php";
require_once "controller/VnpayController.php";
require_once "controller/RatingController.php";
require_once "controller/CouponController.php";
require_once "controller/AddressController.php";
require_once "router/Router.php";
require_once "middleware.php";

$router = new Router();
$productController = new ProductController();
$categoryController = new CategoryController();
$authController = new AuthController();
$sizeController = new SizeController();
$colorController = new ColorController();
$productVariantController = new ProductVariantController();
$cartController = new CartController();
$orderController = new OrderController();
$vnpayController = new VnpayController();
$ratingController = new RatingController();
$couponController = new CouponController();
$addressController = new AddressController();
$controller = new Controller();

$router->addMiddleware('logRequest');


$router->addRoute("/", [$controller, "index"]);
$router->addRoute("/products", [$productController, "index2"]);

$router->addRoute("/admin", [$controller, "admin"], ['checkLogin', 'checkAdmin']);

//product
$router->addRoute("/admin/products", [$productController, "index"], ['checkLogin', 'checkUserOrAdmin']);
$router->addRoute("/products/detail/{id}", [$productController, "show"]);
$router->addRoute("/admin/products/create", [$productController, "create"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/products/edit/{id}", [$productController, "edit"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/products/delete/{id}", [$productController, "delete"], ['checkLogin', 'checkAdmin']);


// Route tìm kiếm sản phẩm
$router->addRoute("/search-suggestions", [$productController, "searchSuggestions"]);


//Product Variant
$router->addRoute("/admin/variants/detail/{id}", [$productVariantController, "show"], ['checkLogin', 'checkUserOrAdmin']);
$router->addRoute("/admin/products/variants/create/{id}", [$productVariantController, "create"], ['checkLogin', 'checkAdmin']);
// $router->addRoute("/variants/edit/{id}", [$productVariantController, "edit"], ['checkLogin', 'checkAdmin']);
// $router->addRoute("/variants/delete/{id}", [$productVariantController, "delete"], ['checkLogin', 'checkAdmin']);

//user
$router->addRoute("/admin/users", [$authController, "indexUser"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/users/delete/{id}", [$authController, "delete"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/users/edit/{id}", [$authController, "editRole"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/profile/update/{id}", [$authController, "updateProfile"], ['checkLogin', 'checkUserOrAdmin']);

//category
$router->addRoute("/admin/category", [$categoryController, "index"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/category/create", [$categoryController, "create"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/category/edit/{id}", [$categoryController, "edit"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/category/delete/{id}", [$categoryController, "delete"], ['checkLogin', 'checkAdmin']);

//usser
$router->addRoute("/login", [$authController, "login"]);
$router->addRoute("/register", [$authController, "register"]);
$router->addRoute("/logout", [$authController, "logout"]);
$router->addRoute("/", [$controller, "index"]);
$router->addRoute("/profile/{id}", [$authController, "show"], ['checkLogin', 'checkUserOrAdmin']);
$router->addRoute("/login/google", [$authController, "redirectToGoogle"]);
$router->addRoute("/auth/google-login", [$authController, "googleCallback"]);

//forgot password
$router->addRoute("/forgot-password", [$authController, "forgotPassword"]);
$router->addRoute("/reset-password", [$authController, "resetPassword"]);

//size
$router->addRoute("/admin/sizes", [$sizeController, "index"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/sizes/create", [$sizeController, "create"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/sizes/edit/{id}", [$sizeController, "edit"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/sizes/delete/{id}", [$sizeController, "delete"], ['checkLogin', 'checkAdmin']);

//color
$router->addRoute("/admin/colors", [$colorController, "index"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/colors/create", [$colorController, "create"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/colors/edit/{id}", [$colorController, "edit"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/colors/delete/{id}", [$colorController, "delete"], ['checkLogin', 'checkAdmin']);

//Variants
$router->addRoute("/admin/products/show_variant/{id}", [$productVariantController, "show"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/products/variants/delete/{id}", [$productVariantController, "delete"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/products/variants/edit/{id}", [$productVariantController, "edit"], ['checkLogin', 'checkAdmin']);

//cart
$router->addRoute("/carts", [$cartController, "index"]);
$router->addRoute("/carts/addToCart", [$cartController, "addCart"]);
$router->addRoute("/carts/delete/{id}", [$cartController, "delete"]);
$router->addRoute("/carts/deleteAll", [$cartController, "deleteAll"]);
$router->addRoute("/carts/update", [$cartController, "update"]);

//Order
$router->addRoute("/checkout", [$orderController, "createOrder"], ['checkLogin', 'checkUserOrAdmin']);
$router->addRoute("/vnpay", [$vnpayController, "createPayment"], ['checkLogin', 'checkUserOrAdmin']);
$router->addRoute("/vnpay/callback", [$vnpayController, "vnpayReturn"], ['checkLogin', 'checkUserOrAdmin']);
$router->addRoute("/admin/orders", [$orderController, "admin"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/orders/update/{id}", [$orderController, "updateStatus"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/orders/delete/{id}", [$orderController, "delete"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/orders", [$orderController, "index"], ['checkLogin', 'checkUserOrAdmin']);
$router->addRoute("/orders/show/{id}", [$orderController, "show"], ['checkLogin', 'checkUserOrAdmin']);

//Tracking
$router->addRoute("/tracking", [$orderController, "trackOrder"], ['checkLogin', 'checkUserOrAdmin']);

//Rating
$router->addRoute("/ratings/create", [$ratingController, "addRating"], ['checkLogin', 'checkUserOrAdmin']);

//coupons
$router->addRoute("/admin/coupons", [$couponController, "index"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/coupons/create", [$couponController, "create"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/coupons/edit/{id}", [$couponController, "edit"], ['checkLogin', 'checkAdmin']);
$router->addRoute("/admin/coupons/delete/{id}", [$couponController, "delete"], ['checkLogin', 'checkAdmin']);

//address 
$router->addRoute("/addresses", [$addressController, "index"], ['checkLogin']);
$router->addRoute("/profile/address/add", [$addressController, "create"], ['checkLogin']);
$router->addRoute("/profile/address/edit/{id}", [$addressController, "edit"], ['checkLogin']);


$router->addRoute("/unauthorized", [$authController, "unauthorized"]);

$router->dispatch();
?>