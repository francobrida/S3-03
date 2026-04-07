<?php

require_once __DIR__ . '/../models/factory/TaskFactory.php';
require_once __DIR__ . '/../models/factory/CategoryFactory.php';
require_once __DIR__ . '/../models/factory/UserFactory.php';

class TaskController extends ApplicationController
{  
    protected Task $tasks;

    public function __construct()   
    {
        $this->tasks = TaskFactory::create(); 
    }
    public function indexAction()
    {
        if (!isset($_SESSION['user_id'])){
            header("Location: " . $this->_baseUrl() . "/index");
            exit;
        }
        $this->AddCategories();
        $this->AddUsers();        

        $this->view->states = State::cases();
        
        if (isset($_SESSION['user_id']) && isset($_SESSION['type']) && $_SESSION['type']!= "Admin" ){
            $this->view->tasks = $this->tasks->getUserTasks($_SESSION['user_id']);
        }
        else {
            $this->view->tasks = $this->tasks->getAllTasks();
        }            
    }
    public function addTaskAction()
    {
        if (!isset($_SESSION['user_id'])){
            header("Location: " . $this->_baseUrl() . "/index");
            exit;
        }
        $this->view->addTasks = $this->tasks->getAllTasks();
        $this->view->states = State::cases(); 
  
        $this->AddCategories();
    }
    public function addNewTaskAction()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . $this->_baseUrl() . "/index");
            exit;
        }
        $this->tasks->addTask($_POST['name'], $_POST['description'], $_POST['category_id'], $_POST['start_date'], $_POST['start_time'], $_POST['end_time'], (int) $_SESSION['user_id']);
        $this->view->tasks = $this->tasks->getAllTasks(); 
        
        header("Location: " . $this->_baseUrl() . "/task");
        exit;
    }
    public function deleteTaskAction() : void
    {
        $id = $this->_getParam('id');
        $this->tasks->deleteTask($id);
        
        header("Location: " . $this->_baseUrl() . "/task");
        exit;
    }
    public function editTaskAction() : void
    {
        if (!isset($_SESSION['user_id'])){
            header("Location: " . $this->_baseUrl() . "/index");
            exit;
        }
        $id = $this->_getParam('id');
        $foundTask = $this->tasks->searchTask($id);
        $this->view->task = $foundTask;
        $this->view->states = State::cases();       

        $this->AddCategories();
    }
    public function updateTaskAction() : void 
    {
        $id = (int) $this->_getParam('id');
        $name = trim($this->_getParam('name'));
        $description = trim($this->_getParam('description'));
        $category = (int) $this->_getParam('category_id');
        $state = $this->_getParam('state');
        $start_date = $this->_getParam('start_date');
        $start_time = $this->_getParam('start_time');
        $end_time = $this->_getParam('end_time');
        
        $this->tasks->editTask($id, $name, $description, $category, $state, $start_date, $start_time, $end_time);
        
        header("Location: " . $this->_baseUrl() . "/task");
        exit;
    }
    public function filterAction() : void 
    {
        $this->addCategories();
        $this->addUsers();

       $filters = [
        'user_id'     => $_GET['user_id'] ?? '',
        'category_id' => $_GET['category_id'] ?? '',
        'state'       => $_GET['state'] ?? '',
        'search'      => $_GET['search'] ?? ''
         ];

        if ($_SESSION['type'] !== 'Admin') {
            $filters['user_id'] = $_SESSION['user_id']; 
        } else {
            $filters['user_id'] = $_GET['user_id'] ?? '';
        }

        $this->view->tasks = $this->tasks->filterTasks($filters);

        $this->view->render('task/index.phtml');
        exit;
    }
    public function addCategories() : void
    {
        $categoryModel = CategoryFactory::create(); 
        $categories = $categoryModel->getAllCategories();
        $this->view->categories = $categories;

        $categoriesById = [];
        foreach ($categories as $category) {
            $categoriesById[$category['id']] = $category['name'];
        }
        $this->view->categoriesById = $categoriesById; 

        $categoriesColorById = [];
        foreach ($categories as $category) {
            $categoriesColorById[$category['id']] = $category['color'];
        }
        $this->view->categoriesColorById = $categoriesColorById; 
    }
    public function addUsers() : void
    {
        $userModel = UserFactory::create(); 
        $this->view->users = $userModel->getAllUsers(); 
        
        $userNameById = [];
        foreach ($this->view->users as $user) {
            $userNameById[$user['id']] = $user['nickname'];
        }
        $this->view->userNameById = $userNameById; 
    }
}