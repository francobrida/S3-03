<?php

class CategoryController extends ApplicationController {

    public function indexAction() {
        $categoryModel = new Category();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            $categoryModel->addCategory($name, $description);

            header('Location: /proyecto-php/SPRINT3/S3-03/web/category');
            exit;
        }

        
        $this->view->categories = $categoryModel->getAllCategories();
    }
}
