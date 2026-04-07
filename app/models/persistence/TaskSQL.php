<?php

class TaskSQL extends Model implements TaskStorageInterface{
    
    protected $jsonFile = ROOT_PATH . '/data/tasks.json';
    
    public function __construct()
    {
         parent::__construct();        
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

    public function deleteData(int $id): bool 
    {
       return $this->delete($id);
    }

    public function searchData(int $id) : ?array 
    {
        $task = $this->fetchOne($id);
        if (!$task) {
            return null;
        }
        return (array) $task;            
    }

    public function editTask(int $id, string $name, string $description, 
    int $category, string $state, string $start_date, string $start_time, string $end_time) : void 
    {        
        $dataToSave = [
            'id' => $id,
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

            if ($filters['user_id'] != '' && $task['user_id'] != $filters['user_id']) {
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

    public function readData() : array
    {
        $this->_setTable('tasks');
        $sql = "SELECT * FROM tasks";
        $statement = $this->_dbh->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);  
    }

    public function saveData(array $dataToSave) : void
    {
        $this->save($dataToSave);
    }
}
?>