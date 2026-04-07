<?php

class CategorySQL extends Model implements StorageInterface
{

    //public function __construct() {}

    public function init(){
        $this->_setTable('categories');
    }

    public function getAll() : array
    {
        return $this->readData();
    }

    public function addCategory(string $name, string $description, string $color) : void
    {
        $sql = "INSERT INTO " . $this->_table . " (name, description, color) VALUES (?, ?, ?)"; // we prepare the query with placeholders

        $stmt = $this->_dbh->prepare($sql); // statement prepared with PDO

        $stmt->execute([$name, $description, $color]); // we execute the query with the provided values

    }

    public function deleteData(int $id) : bool
    {

        $sql = "DELETE FROM " . $this->_table . " WHERE id = ?"; // we prepare the query with the placeholder

        $stmt = $this->_dbh->prepare($sql); // statement prepared with PDO

        return $stmt->execute([$id]); // we execute the query with the provided value

    }

    public function searchData(int $id) : ?array
    {

        $sql = "SELECT * FROM " . $this->_table . " WHERE id = ?"; // we prepare the query with the placeholder

        $stmt = $this->_dbh->prepare($sql); // statement prepared with PDO

        $stmt->execute([$id]); // we execute the query with the provided value

        $category = $stmt->fetch(PDO::FETCH_ASSOC); // we get the result as an associative array. Fetch is used for a single result, otherwise fetchAll would be used

        return $category ?: null; // we return the category or null if not found

    }

    public function updateCategory(int $id, string $name, string $description, string $color) : void
    {
        $sql = "UPDATE " . $this->_table . 
            " SET name = ?, 
            description = ?, 
            color = ? 
            WHERE id = ?"; // we prepare the query with placeholders

        $stmt = $this->_dbh->prepare($sql); // statement prepared with PDO

        $stmt->execute([$name, $description, $color, $id]); // we execute the query with the provided values
    }

    public function filterCategory(string $searchByName): array
    {
        $sql = "SELECT * FROM " . $this->_table . " WHERE name LIKE ?"; // we prepare the query with the placeholder

        $stmt = $this->_dbh->prepare($sql); // statement prepared with PDO

        $stmt->execute(['%' . $searchByName . '%']); // we execute the query with the provided value, using % for partial matches

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // we return the results as an associative array


    }
    
     public function readData() : array
    {
        // MySQL reading logic
        $this->_setTable('categories');
        $sql = "SELECT * FROM categories";
        $statement = $this->_dbh->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveData(array $dataToSave) : void
    {
        // MySQL saving logic
        $this->save($dataToSave);
    }
}