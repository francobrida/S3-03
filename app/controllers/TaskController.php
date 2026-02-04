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
        $this->view->tasks = $this->tasks->getAllTasks(); //shows all           
    }
    public function addTaskAction()
    {
        $this->tasks->addTask($_POST['name'], $_POST['description']);
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
        $this->view->task = $foundTask;                
    }

    public function updateTaskAction() : void 
    {
        $id_task = (int) $this->_getParam('id_task');
        $name = trim($this->_getParam('name'));
        $description = trim($this->_getParam('description'));
        $category = $this->_getParam('category');
        $state = $this->_getParam('state');
        
        $this->tasks->editTask($id_task, $name, $description, $category, $state);
        
        header("Location: " . $this->_baseUrl() . "/task");
        exit;
    }

}