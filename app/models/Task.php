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
    public function addTask(string $name, string $description, int $category_id) {
        $tasks = $this->getAllTasks();

        $newTask = [
            'id_task' => count($tasks) + 1,
            'name' => $name,
            'description' => $description,
            'category_id' => $category_id, 
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
    public function deleteTask(int $id_task) {
        $tasks = $this->getAllTasks();

        // Filter out the task with the given id_task
        $tasks = array_filter($tasks, function($task) use ($id_task) {
            return $task['id_task'] != $id_task;
        });

        // Re-index the array to maintain sequential keys
        $tasks = array_values($tasks);

        $dataToSave = ['tasks' => $tasks];
        file_put_contents($this->jsonFile, json_encode($dataToSave, JSON_PRETTY_PRINT));      
    }

    public function searchTask(int $id_task) : ?array 
    {
        $tasks = $this->getAllTasks();
        foreach ($tasks as $task) {
            if ($task['id_task'] == $id_task) {
                return $task;
            }
        }
        return null;
    }

    public function editTask(int $id_task, string $name, string $description, 
    int $category, string $state) : void 
    {
        //echo "<br>editTask" . var_dump($state);
        $tasks = $this->getAllTasks();
        $newTasksList = [];

        foreach ($tasks as $task) {
            if ($task['id_task'] == $id_task) {
                $task['name'] = $name;
                $task['description'] = $description;
                $task['category_id'] = $category;
                $task['state'] = $state;                
            }
            $newTasksList[] = $task;
        }

        $data = ['tasks' => $newTasksList];
        file_put_contents($this->jsonFile, json_encode($data, JSON_PRETTY_PRINT));
    }

}

?>