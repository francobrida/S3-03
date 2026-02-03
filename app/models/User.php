<?php
require_once __DIR__ . '/../../lib/base/Model.php';
require_once 'UserType.php';

class User extends Model{

    // Path to the JSON file storing tasks
    protected $jsonFile = ROOT_PATH . '/data/users.json';

    public function __construct(){}

    public function getAllUsers()
    {
        if (!file_exists($this->jsonFile)) {
            return [];
        }

        $jsonContent = file_get_contents($this->jsonFile); //exiting PHP functions -> retrieves a string
        $data = json_decode($jsonContent, true); // existing PHP function  -> decodes THE string 
        // true: turns the string into and array  -> $task['name']

        // Uncomment to debug:
        // die(var_dump($data));

        return isset($data['users']) ? $data['users'] : [];

    }

    public function addUser(string $nickname, string $name, string $surname, string $password, 
    string $email, UserType $type)
    {
        $users = $this->getAllUsers();

        $lastId = 0;
        foreach ($users as $user) {
            if ($user['id'] > $lastId) {
                $lastId = $user['id'];
            }
        }
        // Create a new users array
        $newUser = [
            'id' => $lastId + 1, 
            'nickname' => $nickname,
            'name' => $name,
            'surname' => $surname,
            'password' => $password,
            'email' => $email,
            'type' => $type->value,
            'creation_date' => (new DateTime())->format('Y-m-d H:i:s')
        ];

        // Add the new user to the users array
        $users[] = $newUser;
        // Save the updated tasks array back to the JSON file
        $data = ['users' => $users];
        file_put_contents($this->jsonFile, json_encode($data, JSON_PRETTY_PRINT));
        
    }

    public function deleteUser(int $id_user)
    {
        $users = $this->getAllUsers();

        // Filter out the users with the given id_user
        $users = array_filter($users, function ($users) use ($id_user) {
            return $users['id'] !== $id_user;
        });
        $users = array_values($users);

        // Save the updated user array back to the JSON file
        $data = ['users' => $users];
        file_put_contents($this->jsonFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function searchUser(int $id_user) : ?array 
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
            if ((int)$user['id'] === $id_user) {
                $user['nickname'] = $nickname;
                $user['name'] = $name;
                $user['surname'] = $surname;
                $user['password'] = $password;
                $user['email'] = $email;
                $user['type'] = $type->value;
            }
            $newUsersList[] = $user;
        }

        $data = ['users' => $newUsersList];
        file_put_contents($this->jsonFile, json_encode($data, JSON_PRETTY_PRINT));
    }

}

?>