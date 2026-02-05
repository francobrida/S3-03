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

        $this->view->tasks = $this->tasks->getAllTasks(); //send all tasks   
            
    }
    public function addTaskAction()
    {
        $this->tasks->addTask($_POST['name'], $_POST['description'], $_POST['category_id']);
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
        
        $this->tasks->editTask($id_task, $name, $description, $category, $state);
        
        header("Location: " . $this->_baseUrl() . "/task");
        exit;
    }

}