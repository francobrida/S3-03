<?php

require_once 'persistence/TaskSQL.php';
require_once 'persistence/TaskJSON.php';

class Task {

    private $persistence;

    public function __construct(TaskStorageInterface $persistence) 
    {
        $this->persistence = $persistence;
    }

     public function getAllTasks() : array
    {
        return $this->persistence->getAll();
    }

    public function addTask(string $name, string $description, int $category_id, string $start_date, string $start_time, string $end_time, int $id_user) : void
    {
        $this->persistence->addNewTask($name, $description, $category_id, $start_date, $start_time, $end_time, $id_user);
    }
    public function getUserTasks(int $idUser): array
    {
        return $this->persistence->getUserTasks($idUser);
    }

    public function deleteTask(int $id) : bool
    {
        return $this->persistence->deleteData($id);
    }
    public function searchTask(int $id) : ?array
    {
        return $this->persistence->searchData($id);
    }

    public function filterTasks(array $filters) : array 
    {
        return $this->persistence->filterTasks($filters);
    }
    
    public function editTask(int $id, string $name, string $description, 
    int $category, string $state, string $start_date, string $start_time, string $end_time) : void
    {
        $this->persistence->editTask($id, $name, $description, $category, $state, $start_date, $start_time, $end_time);
    }
}