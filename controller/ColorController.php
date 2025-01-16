<?php
require_once "model/ColorModel.php";
require_once "view/helpers.php";

class ColorController
{
    private $colorModel;

    public function __construct()
    {
        $this->colorModel = new ColorModel();
    }
    public function index()
    {
        $colors = $this->colorModel->getAllcolors();
        renderView("view/skus/color/index.php", compact('colors'), "color List");
    }
    public function show($id)
    {
        $color = $this->colorModel->getColorById($id);
        renderView("view/skus/color/show.php", compact('colors'), "color Detail");
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $errors = $this->validateColor(['name' => $name]);
            if(empty($errors)){
                $this->colorModel->createColor($name);
                $_SESSION['success'] = "Thêm color thành công!";
                header("Location: /colors");
                exit;
            } else{
                renderView("view/skus/color/create.php", compact('errors','name'), "Create color");
            }

            // $this->colorModel->createcolor($name, $description);
            // header("Location: /color");
        } else {
            renderView("view/skus/color/create.php", [], "Create color");
        }
    }
    public function delete($id)
    {
        $this->colorModel->deleteColor($id);
        $_SESSION['success'] = "Xóa color thành công";
        header("Location: /colors");
    }
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $errors=$this->validateColor(['name'=>$name]);

            if(!empty($errors)){
                renderView("view/skus/color/edit.php", compact('errors'), "Edit color");
            }else{
                $this->colorModel->updateColor($id, $name);
                header("Location: /colors");
            }

            $this->colorModel->updateColor($id, $name);
            header("Location: /colors");
        } else {
            $color = $this->colorModel->getColorById($id);
            renderView("view/skus/color/edit.php", compact('color'), "Edit color");
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
