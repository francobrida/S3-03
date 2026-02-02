<?php

class Task extends Model{

    // Path to the JSON file storing tasks
    protected $jsonFile = ROOT_PATH . '/app/models/tasks.json';
    
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
}

?>