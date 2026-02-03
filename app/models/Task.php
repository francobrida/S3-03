<?php

class Task extends Model{

    // Path to the JSON file storing tasks
    protected $jsonFile = ROOT_PATH . '/data/tasks.json';   
    
    public function __construct()
    {
        // By leaving this empty, we don't call parent::__construct()
        // so the app stops looking for a MySQL server.
    } 

    public function getAllTasks()
    {
        if (!file_exists($this->jsonFile)) {
            return [];
        }

        $jsonContent = file_get_contents($this->jsonFile); //exiting PHP functions -> retrieves a string
        $data = json_decode($jsonContent, true); // existing PHP function  -> decodes THE string 
        // true: turns the string into and array  -> $task['name']

        // ** DEBUG: See what PHP actually thinks the data looks like
        
        return isset($data['tasks']) ? $data['tasks'] : [];        
    }

    public function addTask(string $name, string $description) {
        $tasks = $this->getAllTasks();

        $newTask = [
            'id_task' => count($tasks) + 1,
            'name' => $name,
            'description' => $description,
            'category' => 'general', // default category
            'state' => 'pending',
            'start_time' => null,
            'end_time' => null,
            'creation_date' => date("Y-m-d H:i:s"),
            'id_user' => 1 // Assuming a default user for simplicity
        ];

        $tasks[] = $newTask;

        $dataToSave = ['tasks' => $tasks];
        file_put_contents($this->jsonFile, json_encode($dataToSave, JSON_PRETTY_PRINT));      
    }

    
}

?>