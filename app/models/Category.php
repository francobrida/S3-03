<?php

require_once 'Adapters/CategorySQL.php';
require_once 'Adapters/CategoryJSON.php';

class Category 
{
    private $adapter;

    public function __construct() 
    {
        // Switch here between new CategorySQL() and new CategoryJSON() to change persistance.
        $this->adapter = new CategorySQL(); 
        //$this->adapter = new CategoryJSON(); 
    }


    public function getAllCategories() : array {
        return $this->adapter->getAll();
    }

    public function addCategory(string $name, string $description, string $color) : void {
        $this->adapter->addCategory($name, $description, $color);
    }

    public function deleteCategory(int $id) : bool {
        return $this->adapter->deleteData($id);
    }

    public function searchCategory(int $id) : ?array {
        return $this->adapter->searchData($id);
    }

    public function updateCategory(int $id, string $name, string $description, string $color) : void {
        $this->adapter->updateCategory($id, $name, $description, $color);
    }

    public function filterCategory(string $searchByName) : array {
        return $this->adapter->filterCategory($searchByName);
    }
}