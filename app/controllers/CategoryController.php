<?php

class CategoryController extends ApplicationController {

    public function indexAction() {
        $categoryModel = new Category();

        if (!isset($_SESSION['user_id'])){
            header("Location: " . $this->_baseUrl() . "/index");
            exit;
        }

        $this->view->categories = $categoryModel->getAllCategories();
  }

    public function addAction(){

        if (!isset($_SESSION['user_id'])){
              header("Location: " . $this->_baseUrl() . "/index");
              exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $name = $_POST['name'] ?? '';
          $description = $_POST['description'] ?? '';
          $color = $_POST['color'] ?? 'teal-600';

          $categoryModel = new Category();
          $categoryModel->addCategory($name, $description, $color);

          // Redirigir solo después de POST
          header("Location: " . WEB_ROOT . "/category");
          exit;
      }

      $this->view->category;
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
      
      if (!isset($_SESSION['user_id'])){
              header("Location: " . $this->_baseUrl() . "/index");
              exit;
      }
      
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
      $color = $_POST['color'] ?? 'teal-600';
        
      $categoryModel = new Category();
      $categoryModel->updateCategory($id, $name, $description, $color);
        
      header('Location: ' . WEB_ROOT . '/category');
      exit;
    }

    public function filterAction() : void {
      
      $searchByName = $_GET['search'] ?? '';
      $categoryModel = new Category();
    
      $this->view->categories = $categoryModel->filterCategory($searchByName);

      $this->view->render('category/index.phtml');
      exit;
    }
}
