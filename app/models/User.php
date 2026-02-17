<?php
require_once __DIR__ . '/../../lib/base/Model.php';
require_once 'UserType.php';

class User extends Model{

    // Path to the JSON files storing users and tasks
    protected $jsonUsers = ROOT_PATH . '/data/users.json';
    protected $jsonTasks = ROOT_PATH . '/data/tasks.json';

    public function __construct(){}

    public function getAllUsers() : array
    {
        $data = $this->ReadData();
        return isset($data['users']) ? $data['users'] : [];  

    }

    public function addUser(string $nickname, string $name, string $surname, string $password, 
    string $email, UserType $type) : array
    {
        $users = $this->getAllUsers();

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
            'password' => $password,
            'email' => $email,
            'type' => $type->value,
            'creation_date' => (new DateTime())->format('Y-m-d H:i:s')
        ];

        $users[] = $newUser;

        // Save the updated tasks array back to the JSON file
        $data = ['users' => $users];
        file_put_contents($this->jsonUsers, json_encode($data, JSON_PRETTY_PRINT)); // JSON_PRETTY_PRINT makes the JSON file more readable for us.
        return $newUser;
    }

    public function deleteUser(int $id_user) : void
    {
        $users = $this->getAllUsers();
        $task = new Task ();
        $tasks = $task->getAllTasks();

        // Filter out the users with the given id_user
        $users = array_filter($users, function ($user) use ($id_user) {
            return $user['id'] !== $id_user;
        });
        $users = array_values($users);

        // Delete every task associated with this user also
        $tasks = array_filter($tasks, function ($task) use ($id_user) {
             return $task['id_user'] !== $id_user;
        });

        $tasks = array_values($tasks);

        $dataToSave = ['tasks' => $tasks];
        file_put_contents($this->jsonTasks, json_encode($dataToSave, JSON_PRETTY_PRINT));  

        // Save the updated user array back to the JSON file
        $data = ['users' => $users];
        $dataToSave = ['tasks' => $tasks];
        $this->SaveData($data);
    }

    public function searchUser(int $id_user) : ?array // return either the user found or null if not found
    {
        $users = $this->getAllUsers();
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
        $users = $this->getAllUsers();
        $newUsersList = [];

        foreach ($users as $user) {
            if ((int)$user['id'] === (int)$id_user) {
                $user['nickname'] = strtolower($nickname);
                $user['name'] = $name;
                $user['surname'] = $surname;
                $user['password'] = $password;
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
        $users = $this->getAllUsers();
        foreach ($users as $user) {
            if (strtolower($user['nickname']) === strtolower(trim($nickname))){ // trim() to erase possible space errors, tolowercase for case insensitive
                if ($user['password'] === $password ) {
                return $user;
                }
            }
        }
        return null;
    } 

    public function isAlreadyUsed(string $nickname): bool 
    { 
        $users = $this->getAllUsers();
        
        foreach ($users as $user) {
            if (strtolower(trim($user['nickname'])) === strtolower(trim($nickname))) { // Compare nicknames using lowercase
                return true; // Match found
            }
        }
        return false; // No match found
    }

    public function filterUser($searchByNickname) : array 
    {
        $users = $this->getAllUsers();
        $filteredUsers = [];

        foreach ($users as $user) {
            if (stripos($user['nickname'], $searchByNickname) !== false) {
                $filteredUsers[] = $user;
            }
        }

        return $filteredUsers;
    }

    public function ReadData() : array
    {
        if (!file_exists($this->jsonUsers)) {
            return [];
        }

        $jsonContent = file_get_contents($this->jsonUsers); //exiting PHP functions -> retrieves a string
        $data = json_decode($jsonContent, true); // existing PHP function  -> decodes THE string 
        return $data;
        // true: turns the string into and array  -> $user['name']

        // ** DEBUG: See what PHP actually thinks the data looks like
    }

    public function SaveData(array $dataToSave) : void
    {
        file_put_contents($this->jsonUsers, json_encode($dataToSave, JSON_PRETTY_PRINT));
    }
}
?>