<?php

class CategoryController extends ApplicationController
{

    protected Category $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function checkLogin(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . $this->_baseUrl() . "/index");
            exit;
        }
    }

    public function indexAction(): void
    {
        $this->checkLogin();
        $this->view->categories = $this->categoryModel->getAllCategories();
    }

    public function addAction(): void
    {
        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $color = $_POST['color'] ?? '';

            $this->categoryModel->addCategory($name, $description, $color);

            header("Location: " . WEB_ROOT . "/category");
            exit;
        }
    }

    public function deleteAction(): void
    {
        $this->checkLogin();

        $id = (int) $this->_getParam('id');
        if ($id > 0) {
            $this->categoryModel->deleteCategory($id);
        }

        header('Location: ' . WEB_ROOT . '/category');
        exit;
    }

    public function editAction(): void
    {
        $this->checkLogin();

        $id = (int) $this->_getParam('id');
        if ($id > 0) {
            $this->view->category = $this->categoryModel->searchCategory($id);
        }
    }

    public function updateAction(): void
    {
        $this->checkLogin();

        $id = (int) $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $color = $_POST['color'] ?? 'bg-red-500';

        $this->categoryModel->updateCategory($id, $name, $description, $color);

        header('Location: ' . WEB_ROOT . '/category');
        exit;
    }

    public function filterAction(): void
    {
        $this->checkLogin();

        $searchByName = $_GET['search'] ?? '';

        $this->view->categories = $this->categoryModel->filterCategory($searchByName);

        $this->view->render('category/index.phtml');
        exit;
    }
}
