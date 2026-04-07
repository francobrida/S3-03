<?php

class UserJSON extends Model implements StorageInterface {

    protected $jsonUsers = ROOT_PATH . '/data/users.json';
    protected $jsonTasks = ROOT_PATH . '/data/tasks.json';

    public function __construct(){}

    public function getAll() : array
    {
        $data = $this->ReadData();
        return isset($data['users']) ? $data['users'] : [];  

    }

    public function addUser(string $nickname, string $name, string $surname, string $password, 
    string $email, UserType $type) : array
    {
        $users = $this->getAll();

        $lastId = 0;
        foreach ($users as $user) {
            if ($user['id'] > $lastId) {
                $lastId = $user['id'];
            }
        }

        $newUser = [
            'id' => $lastId + 1, 
            'nickname' => strtolower($nickname),
            'name' => $name,
            'surname' => $surname,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'email' => $email,
            'type' => $type->value,
            'creation_date' => (new DateTime())->format('Y-m-d H:i:s')
        ];

        $users[] = $newUser;

        $data = ['users' => $users];
        file_put_contents($this->jsonUsers, json_encode($data, JSON_PRETTY_PRINT)); 
        return $newUser;
    }

    public function deleteData(int $id_user) : bool
    {
        $users = $this->getAll();
        $task = new Task ();
        $tasks = $task->getAllTasks();

        $users = array_filter($users, function ($user) use ($id_user) {
            return $user['id'] !== $id_user;
        });
        $users = array_values($users);

        $tasks = array_filter($tasks, function ($task) use ($id_user) {
             return $task['id_user'] !== $id_user;
        });

        $tasks = array_values($tasks);

        $dataToSave = ['tasks' => $tasks];
        file_put_contents($this->jsonTasks, json_encode(['tasks' => $tasks], JSON_PRETTY_PRINT)); 

        $data = ['users' => $users];
        $this->SaveData($data);
        return true;
    }

    public function searchData(int $id_user) : ?array 
    {
        $users = $this->getAll();
        foreach ($users as $user) {
            if ($user['id'] === $id_user) {
                return $user;
            }
        }
        return null;
    }

    public function editUser(int $id_user, string $nickname, string $name, string $surname, 
    string $password, string $email, UserType $type) : void 
    {
        $users = $this->getAll();
        $newUsersList = [];

        foreach ($users as $user) {
            if ((int)$user['id'] === (int)$id_user) {
                $user['nickname'] = strtolower($nickname);
                $user['name'] = $name;
                $user['surname'] = $surname;
                $user['password'] = password_hash($password, PASSWORD_DEFAULT);
                $user['email'] = $email;
                $user['type'] = $type->value;
            }
            $newUsersList[] = $user;
        }

        $data = ['users' => $newUsersList];
        $this->SaveData($data);
    }

    public function authenticateUser(string $nickname, string $password) : ?array 
    {
        $users = $this->getAll();
        foreach ($users as $user) {
            if (strtolower($user['nickname']) === strtolower(trim($nickname))){ 
                if (password_verify($password, $user['password'])) {
                    return $user;
                }
            }
        }
        return null;
    } 

    public function isAlreadyUsed(string $nickname): bool 
    { 
        $users = $this->getAll();
        
        foreach ($users as $user) {
            if (strtolower(trim($user['nickname'])) === strtolower(trim($nickname))) { 
                return true; 
            }
        }
        return false; 
    }

    public function filterUser($searchByNickname) : array 
    {
        $users = $this->getAll();
        $filteredUsers = [];

        foreach ($users as $user) {
            if (stripos($user['nickname'], $searchByNickname) !== false) {
                $filteredUsers[] = $user;
            }
        }

        return $filteredUsers;
    }

    public function readData() : array
    {
        if (!file_exists($this->jsonUsers)) {
            return ['users' => []];
        }

        $jsonContent = file_get_contents($this->jsonUsers); 
        $data = json_decode($jsonContent, true); 
        return $data ?? ['users' => []];;

    }

    public function saveData(array $dataToSave) : void
    {
        file_put_contents($this->jsonUsers, json_encode($dataToSave, JSON_PRETTY_PRINT));
    }
}
?>