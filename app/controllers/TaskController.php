<?php

class TaskController extends ApplicationController
{
  
    protected  $storage;

    public function __construct(StorageInterface $storage = null)   
    {
        //parent::__construct(); // Call the parent constructor to initialize the view and other properties
        $this->storage = $storage ?? new Task(); // Use the provided storage or default to TaskJSON
        //$this->storage = new TaskJSON();// Initialize the Task model (can be TaskJSON or TaskSQL based on your setup)
        //$this->storage = new TaskSQL(); // If you want to use SQL instead of JSON, uncomment this line and comment the previous one.
        //$this->tasks = new Task($this->storage); // Pass the storage to the Task model
    }
    public function indexAction()
    {
        if (!isset($_SESSION['user_id'])){
            header("Location: " . $this->_baseUrl() . "/index");
            exit;
        }
        $this->AddCategories();
        $this->AddUsers();        

        $this->view->states = State::cases(); //send the enum of states
        
        if (isset($_SESSION['user_id']) && isset($_SESSION['type']) && $_SESSION['type']!= "Admin" ){
            $this->view->tasks = $this->tasks->getUserTasks($_SESSION['user_id']);
        }
        else {
            $this->view->tasks = $this->tasks->getAll(); //send all tasks   
        }            
    }
    public function addTaskAction()
    {
        if (!isset($_SESSION['user_id'])){
            header("Location: " . $this->_baseUrl() . "/index");
            exit;
        }
        $this->view->addTasks = $this->tasks->getAll(); //send all tasks
        $this->view->states = State::cases(); //send the enum of states
  
        $this->AddCategories();
    }
    public function addNewTaskAction()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . $this->_baseUrl() . "/index");
            exit;
        }
        $this->tasks->addNewTask($_POST['name'], $_POST['description'], $_POST['category_id'], $_POST['start_date'], $_POST['start_time'], $_POST['end_time'], (int) $_SESSION['user_id']);
        $this->view->tasks = $this->tasks->getAll(); //shows all

        // Redirect to avoid form resubmission
        header("Location: " . $this->_baseUrl() . "/task");
        exit;
    }
    public function deleteTaskAction() : void
    {
        $id_task = $this->_getParam('id_task');
        $this->tasks->deleteData($id_task);
        
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
        //$id_task = $this->_getParam('id_task');
        $id_task = $this->_getParam('id');
        $foundTask = $this->tasks->searchData($id_task);
        $this->view->task = $foundTask;
        $this->view->states = State::cases(); //send the enum of states        

        $this->AddCategories();
    }
    public function updateTaskAction() : void 
    {
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
    public function filterAction() : void 
    {
        $this->AddCategories();
        $this->AddUsers();

        // Filters
       $filters = [
        'user_id'     => $_GET['user_id'] ?? '',
        'category_id' => $_GET['category_id'] ?? '',
        'state'       => $_GET['state'] ?? '',
        'search'      => $_GET['search'] ?? ''
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
    public function AddCategories() : void
    {
        // 1 Get and send all categories
        $categoryModel = new Category(); 
        $categories = $categoryModel->getAllCategories(); //get all categories
        $this->view->categories = $categories; //send to view all categories

        // 2 Diccionary for category name by id
        $categoriesById = [];
        foreach ($categories as $category) {
            $categoriesById[$category['id']] = $category['name'];
        }
        $this->view->categoriesById = $categoriesById; //send categories name diccionary

        // 3 Diccionary for category color by id
        $categoriesColorById = [];
        foreach ($categories as $category) {
            $categoriesColorById[$category['id']] = $category['color'];
        }
        $this->view->categoriesColorById = $categoriesColorById; //send categories color diccionary
    }
    public function AddUsers() : void
    {
        // 1 Get and send all users
        $userModel = new User(); 
        $this->view->users = $userModel->getAllUsers(); //send all users
        
        // 2 Diccionary for nickname by id
        $userNameById = [];
        foreach ($this->view->users as $user) {
            $userNameById[$user['id']] = $user['nickname'];
        }
        $this->view->userNameById = $userNameById; //send nickname diccionary
    }
}