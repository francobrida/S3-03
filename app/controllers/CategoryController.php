<?php

class CategoryController extends ApplicationController {

    public function indexAction() {
        $categoryModel = new Category();
        $this->view->categories = $categoryModel->getAllCategories();
  }

    public function addAction(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $name = $_POST['name'] ?? '';
          $description = $_POST['description'] ?? '';

          $categoryModel = new Category();
          $categoryModel->addCategory($name, $description);
      }

      header("Location: " . WEB_ROOT . "/category");
      exit;
    }

    public function deleteAction(){
      if (isset($_GET['id'])) { 
          $id = (int) $_GET['id'];

          $categoryModel = new Category();
          $categoryModel->deleteCategory($id);
      }

      header('Location: ' . WEB_ROOT . '/category');
      exit;
  


    }
}
