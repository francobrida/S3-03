<?php

interface TaskStorageInterface {
    public function getAll(): array;
    public function saveData(array $data) : void;
    public function readData() : array;
    public function deleteData(int $id) : bool;
    public function searchData(int $id) : ?array;
    public function filterTasks(array $filters) : array;
    public function editTask(int $id, string $name, string $description, 
    int $category, string $state, string $start_date, string $start_time, string $end_time) : void; 
    public function addNewTask(string $name, string $description, int $category_id, string $start_date, string $start_time, string $end_time, int $id_user) : void; 
    public function getUserTasks(int $idUser): array;
}

?>