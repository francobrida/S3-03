<?php

class Category extends Model{

 
    protected $jsonFile = ROOT_PATH . '/data/categories.json';
    
    public function __construct(){
      
    } 

    public function getAllCategories(){
        if (!file_exists($this->jsonFile)) {
            return [];
        }
        $jsonContent = file_get_contents($this->jsonFile); 
        $data = json_decode($jsonContent, true); 
        return isset($data['categories']) ? $data['categories'] : [];        
    }

    public function addCategory($name, $description){
        
    $categories = $this->getAllCategories();
        if (empty($categories)) {
            $newId = 1;
        } else{
            $lastCategory = end($categories);
            $newId = $lastCategory['id'] + 1;
        }

        $categories[] = [
            'id' => $newId,
            'name' => $name,
            'description' => $description
            ];

            
        return file_put_contents(
            $this->jsonFile,
            json_encode(['categories' => $categories], JSON_PRETTY_PRINT)
        );
    }



    

}

?>