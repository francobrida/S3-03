<?php

class Task extends Model implements StorageInterface{
    
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

    public function getAll(): array
    {
        $data = $this->readData();
        return $data;
    }

    public function getUserTasks(int $idUser): array
    {
        $data = $this->getAll();
        return array_filter($data, function ($task) use ($idUser) {
            return isset($task['user_id']) && $task['user_id'] === $idUser;
        });
    }

    public function addNewTask(string $name, string $description, int $category_id, string $start_date, string $start_time, string $end_time, int $id_user): void 
    {
        $dataToSave = [
            'name' => $name,
            'description' => $description,
            'category_id' => $category_id,
            'state' => 'pending',
            'start_date' => $start_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'creation_date' => date("Y-m-d H:i:s"),
            'user_id' => $id_user 
        ];
        $this->saveData($dataToSave);
    }

    public function deleteData(int $id_task): bool 
    {
       return $this->delete($id_task);
    }

    public function searchData(int $id_task) : ?array 
    {
        $task = $this->fetchOne($id_task);
        if (!$task) {
            return null;
        }
        return (array) $task;            
    }

    public function editTask(int $id_task, string $name, string $description, 
    int $category, string $state, string $start_date, string $start_time, string $end_time) : void 
    {        
        $dataToSave = [
            'id' => $id_task,
            'name' => $name,
            'description' => $description,
            'category_id' => $category,
            'state' => $state,
            'start_date' => $start_date,
            'start_time' => $start_time,
            'end_time' => $end_time
        ];
        $this->saveData($dataToSave);
    }

   public function filterTasks(array $filters) : array 
   {
        $tasks = $this->getAll();
        $results = []; 

        foreach ($tasks as $task) {
            $keepTask = true;

            // User filter
            if ($filters['user_id'] != '' && $task['user_id'] != $filters['user_id']) {
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

    public function readData() : array
    {
        //MySQL reading logic
        $this->_setTable('tasks');
        $sql = "SELECT * FROM tasks";
        $statement = $this->_dbh->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);  
    }

    public function saveData(array $dataToSave) : void
    {
        //MysQL saving logic
        $this->save($dataToSave);
    }
}

?>