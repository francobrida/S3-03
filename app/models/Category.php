<?php

class Category extends Model
{

    //public function __construct() {}

    public function init(){
        $this->_setTable('categories');
    }

    public function getAllCategories()
    {
        //ejecutamos la consulta con la qwey para todas las categorias
        $stmt = $this->_dbh->query("SELECT * FROM " . $this->_table);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); //devuelve datos en un array asociativo
        
    }

    public function addCategory(string $name, string $description, string $color) : void
    {
        $sql = "INSERT INTO " . $this->_table . " (name, description, color) VALUES (?, ?, ?)"; //preparamos la consulta con los placeholders

        $stmt = $this->_dbh->prepare($sql); //statment preparado con PDO

        $stmt->execute([$name, $description, $color]); //ejecutamos la consulta con los valores proporcionados

    }

    public function deleteCategory(int $id) : void
    {

        $sql = "DELETE FROM " . $this->_table . " WHERE id = ?"; //preparamos la consulta con el placeholder

        $stmt = $this->_dbh->prepare($sql); //statment preparado con PDO

        $stmt->execute([$id]); //ejecutamos la consulta con el valor proporcionado

    }

    public function searchCategory(int $id) : ?array
    {

        $sql = "SELECT * FROM " . $this->_table . " WHERE id = ?"; //preparamos la consulta con el placeholder

        $stmt = $this->_dbh->prepare($sql); //statment preparado con PDO

        $stmt->execute([$id]); //ejecutamos la consulta con el valor proporcionado

        $category = $stmt->fetch(PDO::FETCH_ASSOC); //obtenemos el resultado como un array asociativo

        return $category ?: null; //devolvemos la categoría o null si no se encuentra

    }

    public function updateCategory(int $id, string $name, string $description, string $color)
    {
        $categories = $this->getAllCategories();

        foreach ($categories as $key => $category) {
            if ($category['id'] === $id) {
                $categories[$key]['name'] = $name;
                $categories[$key]['description'] = $description;
                $categories[$key]['color'] = $color;
                break;
            }
        }

        return file_put_contents(
            $this->jsonFile,
            json_encode(['categories' => $categories], JSON_PRETTY_PRINT)
        );
    }

    public function filterCategory($searchByName): array
    {
        $categories = $this->getAllCategories();
        $filteredCategories = [];

        foreach ($categories as $category) {
            if (stripos($category['name'], $searchByName) !== false) {
                $filteredCategories[] = $category;
            }
        }

        return $filteredCategories;
    }
}
