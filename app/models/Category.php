<?php

require_once 'persistence/CategorySQL.php';
require_once 'persistence/CategoryJSON.php';


class Category 
{
    private $persistence;

    public function __construct(CategoryStorageInterface $persistence) 
    {
        $this->persistence = $persistence;
    }


    public function getAllCategories() : array {
        return $this->persistence->getAll();
    }

    public function addCategory(string $name, string $description, string $color) : void {
        $this->persistence->addCategory($name, $description, $color);
    }

    public function deleteCategory(int $id) : bool {
        return $this->persistence->deleteData($id);
    }

    public function searchCategory(int $id) : ?array {
        return $this->persistence->searchData($id);
    }

    public function updateCategory(int $id, string $name, string $description, string $color) : void {
        $this->persistence->updateCategory($id, $name, $description, $color);
    }

    public function filterCategory(string $searchByName) : array {
        return $this->persistence->filterCategory($searchByName);
    }
}