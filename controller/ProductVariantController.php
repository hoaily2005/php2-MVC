<?php
require_once "model/ProductVariantModel.php";
require_once "model/ProductModel.php";
require_once "model/ColorModel.php";
require_once "model/SizeModel.php";
require_once "view/helpers.php";
require_once 'core/BladeServiceProvider.php';

class ProductVariantController
{
    private $variantModel;
    private $productsModel;
    private $colorsModel;
    private $sizesModel;


    public function __construct()
    {
        $this->variantModel = new ProductVariantModel();
        $this->productsModel = new ProductModel();
        $this->colorsModel = new ColorModel();
        $this->sizesModel = new SizeModel();
    }

    // Danh sách tất cả biến thể sản phẩm
    public function index()
    {
        $variants = $this->variantModel->getAllProductVariant();
        BladeServiceProvider::render("admin/products/variants", compact('variants'), "Danh sách biến thể", 'admin');
    }

    public function show($id)
    {
        $product = $this->productsModel->getProductById($id);

        $variants = $this->variantModel->getProductVariantsByProductId($id);

        BladeServiceProvider::render("admin/products/show_variant", compact('product', 'variants'), "Chi tiết biến thể", 'admin');
    }



    public function create($product_id = null)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $product_id = $_POST['product_id'];
            $color_id = $_POST['color_id'];
            $size_id = $_POST['size_id'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $sku = $_POST['sku'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = $_FILES['image'];

                $uploadDirectory = 'uploads/';
                $imageName = basename($image['name']);
                $uploadPath = $uploadDirectory . $imageName;
                if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
                    $imagePath = $uploadPath;
                } else {
                    $_SESSION['swal'] = ['type' => 'error', 'message' => 'Lỗi tải lên hình ảnh.'];
                    return;
                }
            } else {
                $_SESSION['swal'] = ['type' => 'error', 'message' => 'Vui lòng chọn hình ảnh.'];
                return;
            }

            $errors = $this->checkExits($_POST);
            if (!empty($errors)) {
                BladeServiceProvider::render("admin/products/variants", compact('errors'), "Thêm biến thể", 'admin');
                return;
            }

            if ($this->variantModel->checkDuplicateVariant($product_id, $color_id, $size_id)) {
                $_SESSION['swal'] = ['type' => 'error', 'message' => 'Biến thể đã tồn tại!'];
                return;
            }

            if ($this->variantModel->createVariant($product_id, $color_id, $size_id, $quantity, $price, $sku, $imagePath)) {
                $_SESSION['swal'] = ['type' => 'success', 'message' => 'Thêm biến thể thành công!'];
                header("Location: /admin/products/show_variant/{$product_id}");
                exit();
            } else {
                $_SESSION['swal'] = ['type' => 'error', 'message' => 'Thêm biến thể thất bại!'];
            }
        }

        $products = $this->productsModel->getAllProducts();
        $colors = $this->colorsModel->getAllColors();
        $sizes = $this->sizesModel->getAllSizes();

        BladeServiceProvider::render("admin/products/variants", compact('products', 'colors', 'sizes', 'product_id'), "Thêm biến thể", 'admin');
    }



    public function checkExits($data)
    {
        $errors = [];

        if (!isset($data['product_id']) || empty($data['product_id'])) {
            $errors['product_id'] = "Vui lòng chọn sản phẩm.";
        }
        if (!isset($data['color_id']) || empty($data['color_id'])) {
            $errors['color_id'] = "Vui lòng chọn màu sắc.";
        }
        if (!isset($data['size_id']) || empty($data['size_id'])) {
            $errors['size_id'] = "Vui lòng chọn kích thước.";
        }
        if (!isset($data['quantity']) || empty($data['quantity'])) {
            $errors['quantity'] = "Vui lòng nhập số lượng.";
        } elseif (!is_numeric($data['quantity']) || $data['quantity'] <= 0) {
            $errors['quantity'] = "Số lượng phải là một số lớn hơn 0.";
        }
        if (!isset($data['price']) || empty($data['price'])) {
            $errors['price'] = "Vui lòng nhập giá.";
        } elseif (!is_numeric($data['price']) || $data['price'] <= 0) {
            $errors['price'] = "Giá phải là một số lớn hơn 0.";
        }
        if (!isset($data['sku']) || empty($data['sku'])) {
            $errors['sku'] = "Vui lòng nhập mã SKU.";
        }

        return $errors;
    }

    public function edit($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $product_id = $_POST['product_id'];
            $color_id = $_POST['color_id'];
            $size_id = $_POST['size_id'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $sku = $_POST['sku'];

            $image = isset($_FILES['image']) ? $_FILES['image'] : null;

            if (!$this->validateVariant($_POST)) {
                BladeServiceProvider::render("admin/products/edit_variant", ['error' => "Vui lòng nhập đầy đủ thông tin"], "Chỉnh sửa biến thể", 'admin');
                return;
            }

            if ($this->variantModel->updateVariant($id, $product_id, $color_id, $size_id, $quantity, $price, $sku, $image)) {
                $_SESSION['swal'] = ['type' => 'success', 'message' => 'Chỉnh sửa biến thể thành công!'];
                header("Location: /admin/products/show_variant/{$product_id}");
                exit();
            } else {
                echo "Cập nhật biến thể thất bại!";
            }
        } else {
            $variant = $this->variantModel->getVariantById($id);
            $products = $this->productsModel->getAllProducts();
            $colors = $this->colorsModel->getAllColors();
            $sizes = $this->sizesModel->getAllSizes();

            BladeServiceProvider::render("admin/products/edit_variant", compact('variant', 'products', 'colors', 'sizes'), "Chỉnh sửa biến thể", 'admin');
        }
    }



    public function delete($id)
    {
        if ($this->variantModel->deleteVariant($id)) {
            header("Location: /admin/products");
            exit();
        } else {
            echo "Xóa biến thể thất bại!";
        }
    }

    private function validateVariant($data)
    {
        return isset($data['product_id'], $data['color_id'], $data['size_id'], $data['quantity'], $data['price'], $data['sku'])
            && !empty($data['product_id']) && !empty($data['color_id']) && !empty($data['size_id'])
            && !empty($data['quantity']) && !empty($data['price']) && !empty($data['sku']);
    }
}
