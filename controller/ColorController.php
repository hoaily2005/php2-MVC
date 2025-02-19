<?php
require_once "model/ColorModel.php";
require_once "view/helpers.php";
require_once 'core/BladeServiceProvider.php';


class ColorController
{
    private $colorModel;

    public function __construct()
    {
        $this->colorModel = new ColorModel();
    }
    public function index()
    {
        $title = "color List";
        $colors = $this->colorModel->getAllcolors();
        BladeServiceProvider::render("admin/skus/color/index", compact('colors', 'title'), 'admin');
    }
    public function show($id)
    {
        $title = "color Detail";
        $color = $this->colorModel->getColorById($id);
        BladeServiceProvider::render("admin/skus/color/show", compact('color', 'title'), 'admin');
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $title = "Create color";
            $errors = $this->validateColor(['name' => $name]);
            if(empty($errors)){
                $this->colorModel->createColor($name);
                $_SESSION['success'] = "Thêm color thành công!";
                header("Location: /admin/colors");
                exit;
            } else{
                BladeServiceProvider::render("admin/skus/color/create", compact('errors','name', 'title'), 'admin');
            }

            // $this->colorModel->createcolor($name, $description);
            // header("Location: /color");
        } else {
            BladeServiceProvider::render("admin/skus/color/create", ['title' => "Create color"], "Create color", 'admin');
        }
    }
    public function delete($id)
    {
        $this->colorModel->deleteColor($id);
        $_SESSION['success'] = "Xóa color thành công";
        header("Location: /admin/colors");
    }
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $errors=$this->validateColor(['name'=>$name]);

            if(!empty($errors)){
                BladeServiceProvider::render("admin/skus/color/edit", compact('errors'), "Edit color", 'admin');
            }else{
                $this->colorModel->updateColor($id, $name);
                header("Location: /admin/colors");
            }

            $this->colorModel->updateColor($id, $name);
            header("Location: /admin/colors");
        } else {
            $color = $this->colorModel->getColorById($id);
            BladeServiceProvider::render("admin/skus/color/edit", compact('color'), "Edit color", 'admin');
        }
    }
    private function validateColor($color) {
        $errors = [];
        if (empty($color['name'])) {
            $errors['name'] = "Vui lòng điền tên";
        }
        return $errors;
    }
}
