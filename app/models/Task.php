<?php

class Task extends Model{
    
    protected $jsonFile = ROOT_PATH . '/data/tasks.json'; // Path to the JSON file storing tasks
    
    public function __construct()
    {
        // By leaving this empty, we don't call parent::__construct()
        // so the app stops looking for a MySQL server.
         parent::__construct(); // If you want to keep the database connection, otherwise remove this line.
        
    } 
    public function init()
    {
        $this->_setTable('tasks');
    }
    public function getSQLAllTasks()
    {
        $this->_setTable('tasks');
        $sql = "SELECT * FROM tasks";
        $statement = $this->_dbh->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllTasks(): array
    {
        $data = $this->ReadData();
        //return isset($data['tasks']) ? $data['tasks'] : [];        
        return $data;
    }
    public function getUserTasks(int $idUser): array
    {
        $data = $this->getAllTasks();
        return array_filter($data, function ($task) use ($idUser) {
            //return isset($task['id_user']) && $task['id_user'] === $idUser;
            return isset($task['id']) && $task['id'] === $idUser;
        });
    }
    public function addNewTask(string $name, string $description, int $category_id, string $start_date, string $start_time, string $end_time, int $id_user): void 
    {
        /*
        $tasks = $this->getAllTasks();
        
        $newTask = [
            'id_task' => count($tasks) + 1,
            'name' => $name,
            'description' => $description,
            'category_id' => $category_id, 
            'state' => 'pending',
            'start_date' => $start_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'creation_date' => date("Y-m-d H:i:s"),
            'id' => $id_user 
        ];

        $tasks[] = $newTask;

        $dataToSave = ['tasks' => $tasks];
        $this->SaveData($dataToSave);
        */
        $this->save([
            'name' => $name,
            'description' => $description,
            'category_id' => $category_id,
            'state' => 'pending',
            'start_date' => $start_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'creation_date' => date("Y-m-d H:i:s"),
            'user_id' => $id_user 
        ]);
    }
    public function deleteTask(int $id_task): void 
    {
        /*
        $tasks = $this->getAllTasks();

        // Filter out the task with the given id_task
        $tasks = array_filter($tasks, function($task) use ($id_task) {
            return $task['id_task'] != $id_task;
        });

        // Re-index the array to maintain sequential keys
        $tasks = array_values($tasks);

        $dataToSave = ['tasks' => $tasks];
        $this->SaveData($dataToSave);
        */
        $this->delete($id_task);
    }

    public function searchTask(int $id_task) : ?array 
    {
        $tasks = $this->getAllTasks();
        foreach ($tasks as $task) {
            //if ($task['id_task'] == $id_task) {
            if ($task['id'] == $id_task) {
                return $task;
            }
        }
        return null;
    }

    public function editTask(int $id_task, string $name, string $description, 
    int $category, string $state, string $start_date, string $start_time, string $end_time) : void 
    {
        /*
        $tasks = $this->getAllTasks();
        $newTasksList = [];

        foreach ($tasks as $task) {
            if ($task['id_task'] == $id_task) {
                $task['name'] = $name;
                $task['description'] = $description;
                $task['category_id'] = $category;
                $task['state'] = $state;
                $task['start_date'] = $start_date;
                $task['start_time'] = $start_time;
                $task['end_time'] = $end_time;
            }
            $newTasksList[] = $task;
        }

        $dataToSave = ['tasks' => $newTasksList];
        $this->SaveData($dataToSave);
        */
        $this->save([
            'id' => $id_task,
            'name' => $name,
            'description' => $description,
            'category_id' => $category,
            'state' => $state,
            'start_date' => $start_date,
            'start_time' => $start_time,
            'end_time' => $end_time
        ]);
    }

   public function filterTasks(array $filters) : array 
   {
        $tasks = $this->getAllTasks();
        $results = []; 

        foreach ($tasks as $task) {
            $keepTask = true;

            // User filter
            //if ($filters['user_id'] != '' && $task['id_user'] != $filters['user_id']) {
            if ($filters['user_id'] != '' && $task['id'] != $filters['user_id']) {
                $keepTask = false;
            }
            // Category filter
            if ($filters['category_id'] != '' && $task['category_id'] != $filters['category_id']) {
                $keepTask = false;
            }
            // State filter
            if ($filters['state'] != '' && $task['state'] != $filters['state']) {
                $keepTask = false;
            }
            // name filter (input by user)
            if ($filters['search'] != '' && stripos($task['name'], $filters['search']) === false) {
                $keepTask = false;
            }
            // apply the filters
            if ($keepTask) {
                $results[] = $task;
            }
        }
        return $results;
    }

    public function ReadData() : array{
        /*
        if (!file_exists($this->jsonFile)) {
            return [];
        }

        $jsonContent = file_get_contents($this->jsonFile); //exiting PHP functions -> retrieves a string
        $data = json_decode($jsonContent, true); // existing PHP function  -> decodes THE string 
        return $data;
        */
        $this->_setTable('tasks');
        $sql = "SELECT * FROM tasks";
        $statement = $this->_dbh->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
        
    }
    public function SaveData(array $dataToSave) : void
    {
        file_put_contents($this->jsonFile, json_encode($dataToSave, JSON_PRETTY_PRINT));
    }
}

?>