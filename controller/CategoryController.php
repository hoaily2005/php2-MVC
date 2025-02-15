<?php
require_once "model/CategoryModel.php";
require_once "view/helpers.php";

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }
    public function index()
    {
        $categories = $this->categoryModel->getAllCategories();
        renderView("view/admin/category/index.php", compact('categories'), "Category List", 'admin');
    }
    public function show($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        renderView("view/admin/category/show.php", compact('category'), "Category Detail", 'admin');
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];

            $errors = $this->validateCategory(['name' => $name, 'description' => $description]);
            if (empty($errors)) {
                $this->categoryModel->createCategory($name, $description);
                header("Location: /admin/category");
                exit;
            } else {
                renderView("view/admin/category/create.php", compact('errors', 'name', 'description'), "Create Category", 'admin');
            }
        } else {
            renderView("view/admin/category/create.php", [], "Create Category", 'admin');
        }
    }
    public function delete($id)
    {
        $this->categoryModel->deleteCategory($id);
        $_SESSION['success'] = "Danh mục đã được xóa thành công!";
        header("Location: /admin/category");
    }
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $errors = $this->validateCategory(['name' => $name, 'description' => $description]);

            if (!empty($errors)) {
                renderView("view/admin/category/edit.php", compact('errors'), "Edit Category", 'admin');
            } else {
                $this->categoryModel->updateCategory($id, $name, $description);
                header("Location: /admin/category");
            }

            $this->categoryModel->updateCategory($id, $name, $description);
            header("Location: /admin/category");
        } else {
            $category = $this->categoryModel->getCategoryById($id);
            renderView("view/admin/category/edit.php", compact('category'), "Edit Category", 'admin');
        }
    }
    private function validateCategory($category)
    {
        $errors = [];
        if (empty($category['name'])) {
            $errors['name'] = "Vui lòng điền tên";
        }
        if (empty($category['description'])) {
            $errors['description'] = "Vui lòng điền mô tả";
        }
        return $errors;
    }
}
