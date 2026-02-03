<?php

class CategoryController extends ApplicationController {

    public function indexAction() {
        $categoryModel = new Category();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            $categoryModel->addCategory($name, $description);

            header("Location: " . WEB_ROOT . "/category");;
            exit;
        }
        $this->view->categories=$categoryModel->getAllCategories();

    

    }
}
