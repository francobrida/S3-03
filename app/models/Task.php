<?php

require_once 'Adapters/TaskSQL.php';
require_once 'Adapters/TaskJSON.php';

class Task {

    private $adapter;

    public function __construct() 
    {
        // PERSISTENCE switch
        // Switch between new TaskSQL() and new TaskJSON() to change persistance.
        $this->adapter = new TaskSQL(); 
    }

     public function getAllTasks() : array
    {
        return $this->adapter->readData();
    }

    public function addTask(string $name, string $description, int $category_id, string $start_date, string $start_time, string $end_time, int $id_user) : void
    {
        $this->adapter->addNewTask($name, $description, $category_id, $start_date, $start_time, $end_time, $id_user);
    }
    public function getUserTasks(int $idUser): array
    {
        return $this->adapter->getUserTasks($idUser);
    }

    public function deleteTask(int $id) : bool
    {
        return $this->adapter->deleteData($id);
    }
    public function searchTask(int $id) : ?array
    {
        return $this->adapter->searchData($id);
    }

    public function filterTasks(array $filters) : array 
    {
        return $this->adapter->filterTasks($filters);
    }
    
    public function editTask(int $id, string $name, string $description, 
    int $category, string $state, string $start_date, string $start_time, string $end_time) : void
    {
        $this->adapter->editTask($id, $name, $description, $category, $state, $start_date, $start_time, $end_time);
    }
}