<?php
require_once "model/SizeModel.php";
require_once "view/helpers.php";
require_once 'core/BladeServiceProvider.php';

class SizeController
{
    private $sizeModel;

    public function __construct()
    {
        $this->sizeModel = new SizeModel();
    }
    public function index()
    {
        $sizes = $this->sizeModel->getAllSizes();
        BladeServiceProvider::render("admin/skus/size/index", compact('sizes'), "size List", 'admin');
    }
    public function show($id)
    {
        $size = $this->sizeModel->getsizeById($id);
        BladeServiceProvider::render("admin/skus/size/show", compact('sizes'), "size Detail", 'admin');
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $errors = $this->validatesize(['name' => $name]);
            if(empty($errors)){
                $this->sizeModel->createsize($name);
                $_SESSION['success'] = "Thêm size thành công!";

                header("Location: /admin/sizes");
                exit;
            } else{
                BladeServiceProvider::render("admin/skus/size/create", compact('errors','name'), "Create size", 'admin');
            }

            // $this->sizeModel->createsize($name, $description);
            // header("Location: /size");
        } else {
            BladeServiceProvider::render("admin/skus/size/create", [], "Create size", 'admin');
        }
    }
    public function delete($id)
    {
        $this->sizeModel->deletesize($id);
        $_SESSION['success'] = "Xóa size thành công";
        header("Location: /admin/sizes");
    }
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $errors=$this->validatesize(['name'=>$name]);

            if(!empty($errors)){
                BladeServiceProvider::render("admin/skus/size/edit", compact('errors'), "Edit size", 'admin');
            }else{
                $this->sizeModel->updatesize($id, $name);
                header("Location: /admin/sizes");
            }

            $this->sizeModel->updatesize($id, $name);
            header("Location: /admin/sizes");
        } else {
            $size = $this->sizeModel->getSizeById($id);
            BladeServiceProvider::render("admin/skus/size/edit", compact('size'), "Edit size", 'admin');
        }
    }
    private function validatesize($size) {
        $errors = [];
        if (empty($size['name'])) {
            $errors['name'] = "Vui lòng điền tên";
        }
        return $errors;
    }
}
