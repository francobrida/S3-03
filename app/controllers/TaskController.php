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
        //$this->view->tasks = $this->tasks->getAllTasks(); //shows all

        // Redirect to avoid form resubmission
        header("Location: " . $this->_baseUrl() . "/task");
        exit;
    }
}