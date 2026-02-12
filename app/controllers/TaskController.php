<?php

class TaskController extends ApplicationController
{
    protected Task $tasks;

    public function __construct()   
    {
        $this->tasks = new Task();
    }
    public function indexAction()
    {
        if (!isset($_SESSION['user_id'])){
            header("Location: " . $this->_baseUrl() . "/index");
            exit;
        }
        $categoryModel = new Category(); //Si, en el controler de task creo la categoria
        $categories = $categoryModel->getAllCategories(); //send all the categories
        $this->view->categories = $categories; //send all categories

        $categoriesById = [];
        foreach ($categories as $category) {
            $categoriesById[$category['id']] = $category['name'];
        }
        $this->view->categoriesById = $categoriesById; //send categories name diccionary

        $categoriesColorById = [];
        foreach ($categories as $category) {
            $categoriesColorById[$category['id']] = $category['color'];
        }
        $this->view->categoriesColorById = $categoriesColorById; //send categories color diccionary

        $userModel = new User(); //create user model
        $this->view->users = $userModel->getAllUsers(); //send all users for filters
        
        $userNameById = [];
        foreach ($this->view->users as $user) {
            $userNameById[$user['id']] = $user['nickname'];
        }
        $this->view->userNameById = $userNameById;

        $this->view->states = State::cases(); //send the enum of states
        if (isset($_SESSION['user_id']) && isset($_SESSION['type']) && $_SESSION['type']!= "Admin" ){
            $this->view->tasks = $this->tasks->getUserTasks($_SESSION['user_id']);
        }
        else {
            $this->view->tasks = $this->tasks->getAllTasks(); //send all tasks   
        }            
    }
    public function addTaskAction()
    {
        if (!isset($_SESSION['user_id'])){
            header("Location: " . $this->_baseUrl() . "/index");
            exit;
        }
        $this->view->addTasks = $this->tasks->getAllTasks(); //shows all
        $this->view->states = State::cases(); //send the enum of states
  
        $categoryModel = new Category(); //Si, en el controler de task creo la categoria
        $categories = $categoryModel->getAllCategories(); //send all the categories
        $this->view->categories = $categories; //send all categories

        $categoriesById = [];
        foreach ($categories as $category) {
            $categoriesById[$category['id']] = $category['name'];
        }
        $this->view->categoriesById = $categoriesById; //send categories diccionary        
    }

    public function addNewTaskAction()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . $this->_baseUrl() . "/index");
            exit;
        }
        $this->tasks->addNewTask($_POST['name'], $_POST['description'], $_POST['category_id'], $_POST['start_date'], $_POST['start_time'], $_POST['end_time'], (int) $_SESSION['user_id']);
        $this->view->tasks = $this->tasks->getAllTasks(); //shows all

        // Redirect to avoid form resubmission
        header("Location: " . $this->_baseUrl() . "/task");
        exit;
    }
    public function deleteTaskAction() : void
    {
        $id_task = $this->_getParam('id_task');
        $this->tasks->deleteTask($id_task);
        
        // Redirect to avoid form resubmission
        header("Location: " . $this->_baseUrl() . "/task");
        exit;
    }

    public function editTaskAction() : void
    {
        if (!isset($_SESSION['user_id'])){
            header("Location: " . $this->_baseUrl() . "/index");
            exit;
        }
        $id_task = $this->_getParam('id_task');
        $foundTask = $this->tasks->searchTask($id_task);
        $this->view->states = State::cases(); //send the enum of states
        $this->view->task = $foundTask;                

        $categoryModel = new Category(); //Si, en el controler de task creo la categoria
        $categories = $categoryModel->getAllCategories(); //send all the categories
        $this->view->categories = $categories; //send all categories

        $categoriesById = [];
        foreach ($categories as $category) {
            $categoriesById[$category['id']] = $category['name'];
        }
        $this->view->categoriesById = $categoriesById; //send categories diccionary
    }

    public function updateTaskAction() : void 
    {
        //echo "<br>updateTask" . var_dump($this->_getParam('category_id'));
        $id_task = (int) $this->_getParam('id_task');
        $name = trim($this->_getParam('name'));
        $description = trim($this->_getParam('description'));
        $category = (int) $this->_getParam('category_id');
        $state = $this->_getParam('state');
        $start_date = $this->_getParam('start_date');
        $start_time = $this->_getParam('start_time');
        $end_time = $this->_getParam('end_time');
        
        $this->tasks->editTask($id_task, $name, $description, $category, $state, $start_date, $start_time, $end_time);
        
        header("Location: " . $this->_baseUrl() . "/task");
        exit;
    }

    public function filterAction() : void {
        // 1. Cargar datos para los selects
        $categoryModel = new Category();
        $userModel = new User();
        
        // Los guardamos en el objeto view para que $this-> los encuentre
        $this->view->categories = $categoryModel->getAllCategories();
        $this->view->users = $userModel->getAllUsers();

        // 2.1 Diccionario de nombres para la lista de tareas 
        $categoriesById = [];
        foreach ($this->view->categories as $cat) {
            $categoriesById[$cat['id']] = $cat['name'];
        }
        $this->view->categoriesById = $categoriesById;

        // 2.2 Diccionario de colores para la lista de tareas
        $categoriesColorById = [];
        foreach ($this->view->categories as $category) {
            $categoriesColorById[$category['id']] = $category['color'];
        }
        $this->view->categoriesColorById = $categoriesColorById; //send categories color diccionary

        // 2.3 Diccionario de nombres de usuarios para la lista de tareas
        $userNameById = [];
        foreach ($this->view->users as $user) {
            $userNameById[$user['id']] = $user['nickname'];
        }
        $this->view->userNameById = $userNameById;

        // 3. Filtros!
       $filters = [
        'user_id'     => $_GET['user_id'] ?? '',
        'category_id' => $_GET['category_id'] ?? '',
        'state'       => $_GET['state'] ?? '',
        'search'      => $_GET['search'] ?? '' // Captura texto del form
         ];

        // Admin validation
        if ($_SESSION['type'] !== 'Admin') {
            $filters['user_id'] = $_SESSION['user_id']; 
        } else {
            $filters['user_id'] = $_GET['user_id'] ?? ''; // Admin can choose user_id
        }

        $this->view->tasks = $this->tasks->filterTasks($filters);

        $this->view->render('task/index.phtml');
        exit;


    }


}