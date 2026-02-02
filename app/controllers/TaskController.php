<?php

class TaskController extends ApplicationController
{
    public function indexAction()
    {
        $tasks = new Task(); //create task instance

        $this->view->tasks = $tasks->getAllTasks(); //shows all           
    }
}