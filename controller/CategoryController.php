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
        renderView("view/category_list.php", compact('categories'), "Category List");
    }
    public function show($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        renderView("view/category_detail.php", compact('category'), "Category Detail");
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];

            $errors = $this->validateCategory(['name' => $name, 'description' => $description]);
            if(empty($errors)){
                $this->categoryModel->createCategory($name, $description);
                header("Location: /category");
                exit;
            } else{
                renderView("view/category_create.php", compact('errors','name', 'description'), "Create Category");
            }

            // $this->categoryModel->createCategory($name, $description);
            // header("Location: /category");
        } else {
            renderView("view/category_create.php", [], "Create Category");
        }
    }
    public function delete($id)
    {
        $this->categoryModel->deleteCategory($id);
        header("Location: /category");
    }
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $errors=$this->validateCategory(['name'=>$name,'description'=>$description]);

            if(!empty($errors)){
                renderView("view/category_edit.php", compact('errors'), "Edit Category");
            }else{
                $this->categoryModel->updateCategory($id, $name, $description);
                header("Location: /category");
            }

            $this->categoryModel->updateCategory($id, $name, $description);
            header("Location: /category");
        } else {
            $category = $this->categoryModel->getCategoryById($id);
            renderView("view/category_edit.php", compact('category'), "Edit Category");
        }
    }
    private function validateCategory($category) {
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
