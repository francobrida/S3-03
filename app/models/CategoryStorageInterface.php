<?php

interface CategoryStorageInterface {
    public function getAll(): array;
    public function saveData(array $data) : void;
    public function readData() : array;
    public function deleteData(int $id) : bool;
    public function searchData(int $id) : ?array;
    public function addCategory(string $name, string $description, string $color);
    public function updateCategory(int $id, string $name, string $description, string $color);
    public function filterCategory(string $searchByName);
    }

?>