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
          $id = (int) $_GET['id']; //casteo el id a numero entero

          $categoryModel = new Category();
          $categoryModel->deleteCategory($id);
      }

      header('Location: ' . WEB_ROOT . '/category');
      exit;

    }

    public function editAction(){
      if (isset($_GET['id'])){
        $id = (int) $_GET['id'];

        $categoryModel = new Category();
        $category = $categoryModel->searchCategory($id);

        $this->view->category = $category;

      }
    }

    public function updateAction(){
      $id = (int) $_POST['id'];
      $name = $_POST['name'];
      $description = $_POST['description'];
        
      $categoryModel = new Category();
      $categoryModel->updateCategory($id, $name, $description);
        
      header('Location: ' . WEB_ROOT . '/category');
      exit;
    }
}
