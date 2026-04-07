<?php

class TaskJSON extends Model implements TaskStorageInterface {
    
    protected $jsonFile = ROOT_PATH . '/data/tasks.json'; 
    
    public function __construct()
    {

    } 
 
    public function getAll(): array
    {
        $data = $this->readData();
        return isset($data['tasks']) ? $data['tasks'] : [];
    }

    public function getUserTasks(int $idUser): array
    {
        $data = $this->getAll();

        return array_filter($data, function ($task) use ($idUser) {
            return isset($task['id_user']) && $task['id_user'] === $idUser;
        });
    }

    public function addNewTask(string $name, string $description, int $category_id, string $start_date, string $start_time, string $end_time, int $id_user): void 
    {        
        $tasks = $this->getAll();
        
        $newTask = [
            'id' => count($tasks) + 1,
            'name' => $name,
            'description' => $description,
            'category_id' => $category_id, 
            'state' => 'pending',
            'start_date' => $start_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'creation_date' => date("Y-m-d H:i:s"),
            'id_user' => $id_user 
        ];

        $tasks[] = $newTask;

        $dataToSave = ['tasks' => $tasks];
        $this->saveData($dataToSave);
    }

    public function deleteData(int $id): bool 
    {        
        $tasks = $this->getAll();

        $tasks = array_filter($tasks, function($task) use ($id) {
            return $task['id'] != $id;
        });

        $tasks = array_values($tasks);

        $dataToSave = ['tasks' => $tasks];
        $this->saveData($dataToSave);
        return true;
    }

    public function searchData(int $id) : ?array 
    {
        $tasks = $this->getAll();
        foreach ($tasks as $task) {
            if ($task['id'] == $id) {
                return $task;
            }
        }
        return null;           
    }

    public function editTask(int $id, string $name, string $description, 
    int $category, string $state, string $start_date, string $start_time, string $end_time) : void 
    {
        $tasks = $this->getAll();
        $newTasksList = [];

        foreach ($tasks as $task) {
            if ($task['id'] == $id) {
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
        $this->saveData($dataToSave);        
    }

   public function filterTasks(array $filters) : array 
   {
        $tasks = $this->getAll();
        $results = []; 

        foreach ($tasks as $task) {
            $keepTask = true;

            if ($filters['user_id'] != '' && $task['id_user'] != $filters['user_id']) {            
                $keepTask = false;
            }
            if ($filters['category_id'] != '' && $task['category_id'] != $filters['category_id']) {
                $keepTask = false;
            }
            if ($filters['state'] != '' && $task['state'] != $filters['state']) {
                $keepTask = false;
            }
            if ($filters['search'] != '' && stripos($task['name'], $filters['search']) === false) {
                $keepTask = false;
            }
            if ($keepTask) {
                $results[] = $task;
            }
        }
        return $results;
    }

    public function readData() : array{
        if (!file_exists($this->jsonFile)) {
            return [];
        }

        $jsonContent = file_get_contents($this->jsonFile);
        $data = json_decode($jsonContent, true);
        return $data;
    }
    public function saveData(array $dataToSave) : void
    {
        file_put_contents($this->jsonFile, json_encode($dataToSave, JSON_PRETTY_PRINT));
    }
}

?>