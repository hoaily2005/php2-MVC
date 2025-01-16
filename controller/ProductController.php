<?php
require_once "model/ProductModel.php";
require_once "view/helpers.php";

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $products = $this->productModel->getAllProducts();
        //compact: gom bien dien thanh array
        renderView("view/products/index.php", compact('products'), "Product List");
    }

    public function indexHome()
    {
        $products = $this->productModel->getAllProducts();
        renderView("view/index.php", compact('products'), "Product List");
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        renderView("view/products/show.php", compact('product'), "Product Detail");
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $errors = [];

            $errors = $this->validateProduct(['name' => $name, 'description' => $description, 'price' => $price]);

            if (!empty($errors)) {
                renderView("view/products/create.php", compact('errors', 'name', 'description', 'price'), "Create Product");
            } else {
                $this->productModel->createProduct($name, $description, $price);
                $_SESSION['success'] = "Sản phẩm đã được tạo thành công!";
                header("Location: /products");
                exit;
            }
        } else {
            renderView("view/products/create.php", [], "Create Product");
        }
    }


    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            $this->productModel->updateProduct($id, $name, $description, $price);
            header("Location: /products");
        } else {
            $product = $this->productModel->getProductById($id);
            renderView("view/products/edit.php", compact('product'), "Edit Product");
        }
    }
    public function delete($id)
    {
        $this->productModel->deleteProduct($id);
        $_SESSION['success'] = "Sản phẩm đã được xóa thành công!";
        header("Location: /products");
    }
    private function validateProduct($product)
    {
        $errors = [];
        if (empty($product['name'])) {
            $errors['name'] = "Vui lòng nhập tên sản phẩm";
        }
        if (empty($product['description'])) {
            $errors['description'] = "Vui lòng nhập mô tả sản phẩm";
        }
        if (empty($product['price'])) {
            $errors['price'] = "Vui lòng nhập giá sản phẩm";
        }
        return $errors;
    }
}
