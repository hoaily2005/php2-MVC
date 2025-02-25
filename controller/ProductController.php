<?php

use Illuminate\Support\Facades\Blade;

require_once "model/ProductModel.php";
require_once "model/ProductVariantModel.php";
require_once "view/helpers.php";
require_once "model/CategoryModel.php";
require_once 'core/BladeServiceProvider.php';

class ProductController
{
    private $productModel;
    private $variantModel;
    private $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->variantModel = new ProductVariantModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $title = "Product List";
        $products = $this->productModel->getAllProducts();
        //compact: gom bien dien thanh array
        BladeServiceProvider::render("admin/products/index", compact('products', 'title'), 'Product list', 'admin');
    }
    
    public function index2()
    {
        $categoryId = $_GET['category'] ?? '';
        $priceRange = $_GET['price'] ?? '';

        $products = $this->productModel->getProductsFitter($categoryId, $priceRange);

        $categories = $this->categoryModel->getAllCategories();

        BladeServiceProvider::render("product", compact('products', 'categories'));
    }

    public function indexHome()
    {
        $products = $this->productModel->getAllProducts();
        BladeServiceProvider::render("index", compact('products'), "Product List");
    }

    public function show($id)
    {
        $title = "Product Detail";
        $products = $this->productModel->getProductById($id);
        $variants = $this->variantModel->getProductVariantsByProductId($id);

        $categoryId = $products['category_id'];

        $relatedProducts = $this->productModel->getProductsByCategory($categoryId);

        BladeServiceProvider::render("product_detail", compact('products', 'variants', 'relatedProducts', 'title'), "Chi tiết sản phẩm");
    }



    public function handleImageUploads($files)
    {
        $imageUrls = [];
        $uploadDir = 'uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($files['tmp_name'] as $index => $tmpName) {
            $fileName = basename($files['name'][$index]);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($tmpName, $filePath)) {
                $imageUrls[] = $filePath;
            }
        }

        return $imageUrls;
    }

    public function create()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $category_id = $_POST['category'];

            $imageUrls = $this->handleImageUploads($_FILES['images']);

            $errors = $this->validateProduct([
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'quantity' => $quantity,
                'images' => $imageUrls
            ]);

            if (!empty($errors)) {
                BladeServiceProvider::render("admin/products/create", compact('errors', 'name', 'description', 'price', 'quantity', 'imageUrls', 'categories'), "Create Product", 'admin');
            } else {
                $productId = $this->productModel->createProduct($name, $description, $price, $imageUrls[0], $quantity, $category_id);

                foreach ($imageUrls as $index => $imageUrl) {
                    $isMain = ($index == $_POST['main_image']) ? 1 : 0;
                    $this->productModel->addProductImage($productId, $imageUrl, $isMain);
                }

                $_SESSION['success'] = "Product created successfully!";
                header("Location: /admin/products");
                exit;
            }
        } else {
            BladeServiceProvider::render("admin/products/create", compact('categories'), "Create Product", 'admin');
        }
    }



    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $category_id = $_POST['category'];

            $product = $this->productModel->getProductById($id);
            $oldImage = $product['image'];

            $image = $oldImage;

            if ($_FILES['image']['error'] == 0) {
                $imageUrls = $this->handleImageUploads($_FILES['image']);
                if (!empty($imageUrls)) {
                    $image = $imageUrls[0];
                }

                if ($oldImage && file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            $updateSuccess = $this->productModel->updateProduct($id, $name, $description, $price, $image, $quantity, $category_id);

            if ($updateSuccess) {
                $_SESSION['success'] = "Product updated successfully!";
                header("Location: /admin/products");
                exit;
            } else {
                $_SESSION['error'] = "Product update failed!";
                header("Location: /admin/products/edit/$id");
                exit;
            }
        } else {
            // Fetch the product for editing
            $product = $this->productModel->getProductById($id);
            $categoryModel = new CategoryModel();
            $categories = $categoryModel->getAllCategories();
            BladeServiceProvider::render("admin/products/edit", compact('product', 'categories'), "Edit Product", 'admin');
        }
    }




    public function delete($id)
    {
        $this->productModel->deleteProduct($id);
        $_SESSION['success'] = "Sản phẩm đã được xóa thành công!";
        header("Location: /admin/products");
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
        if (empty($product['quantity'])) {
            $errors['quantity'] = "Vui lòng nhập số lượng sản phẩm";
        }
        return $errors;
    }
}
