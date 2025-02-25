<?php
require_once "model/CategoryModel.php";
require_once "view/helpers.php";
require_once 'core/BladeServiceProvider.php';


class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }
    public function index()
    {
        $title = "Category List";
        $categories = $this->categoryModel->getAllCategories();
        BladeServiceProvider::render("admin/category/index", compact('categories', 'title'), "Category List", 'admin');
    }
    public function show($id)
    {
        $title = "Category Detail";
        $category = $this->categoryModel->getCategoryById($id);
        BladeServiceProvider::render("admin/category/show", compact('category', 'title'), "Category Detail", 'admin');
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
                BladeServiceProvider::render("admin/category/create", compact('errors', 'name', 'description'), "Create Category", 'admin');
            }
        } else {
            BladeServiceProvider::render("admin/category/create", [], "Create Category", 'admin');
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
                BladeServiceProvider::render("admin/category/edit", compact('errors'), "Edit Category", 'admin');
            } else {
                $this->categoryModel->updateCategory($id, $name, $description);
                header("Location: /admin/category");
            }

            $this->categoryModel->updateCategory($id, $name, $description);
            header("Location: /admin/category");
        } else {
            $category = $this->categoryModel->getCategoryById($id);
            BladeServiceProvider::render("admin/category/edit", compact('category'), "Edit Category", 'admin');
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
