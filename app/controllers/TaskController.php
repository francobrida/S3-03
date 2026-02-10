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
        $categoryModel = new Category(); //Si, en el controler de task creo la categoria
        $categories = $categoryModel->getAllCategories(); //send all the categories
        $this->view->categories = $categories; //send all categories

        $categoriesById = [];
        foreach ($categories as $category) {
            $categoriesById[$category['id']] = $category['name'];
        }
        $this->view->categoriesById = $categoriesById; //send categories diccionary

        $this->view->states = State::cases(); //send the enum of states
        if (isset($_SESSION['user_id'])){
            $this->view->tasks = $this->tasks->getUserTasks($_SESSION['user_id']);
        }
        else {
            $this->view->tasks = $this->tasks->getAllTasks(); //send all tasks   
        }            
    }
    public function addTaskAction()
    {
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
        $this->tasks->addNewTask($_POST['name'], $_POST['description'], $_POST['category_id'], $_POST['start_date'], $_POST['start_time'], $_POST['end_time']);
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
        echo "<br>updateTask" . var_dump($this->_getParam('category_id'));
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

}