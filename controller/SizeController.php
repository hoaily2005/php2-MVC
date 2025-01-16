<?php
require_once "model/SizeModel.php";
require_once "view/helpers.php";

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
        renderView("view/skus/size/index.php", compact('sizes'), "size List");
    }
    public function show($id)
    {
        $size = $this->sizeModel->getsizeById($id);
        renderView("view/skus/size/show.php", compact('sizes'), "size Detail");
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $errors = $this->validatesize(['name' => $name]);
            if(empty($errors)){
                $this->sizeModel->createsize($name);
                $_SESSION['success'] = "Thêm size thành công!";

                header("Location: /sizes");
                exit;
            } else{
                renderView("view/skus/size/create.php", compact('errors','name'), "Create size");
            }

            // $this->sizeModel->createsize($name, $description);
            // header("Location: /size");
        } else {
            renderView("view/skus/size/create.php", [], "Create size");
        }
    }
    public function delete($id)
    {
        $this->sizeModel->deletesize($id);
        $_SESSION['success'] = "Xóa size thành công";
        header("Location: /sizes");
    }
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $errors=$this->validatesize(['name'=>$name]);

            if(!empty($errors)){
                renderView("view/skus/size/edit.php", compact('errors'), "Edit size");
            }else{
                $this->sizeModel->updatesize($id, $name);
                header("Location: /sizes");
            }

            $this->sizeModel->updatesize($id, $name);
            header("Location: /sizes");
        } else {
            $size = $this->sizeModel->getSizeById($id);
            renderView("view/skus/size/edit.php", compact('size'), "Edit size");
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
