<?php
require_once __DIR__ . '/../../lib/base/Model.php';

class User extends Model{

    // Path to the JSON file storing tasks
    protected $jsonFile = ROOT_PATH . '/app/models/users.json';

    public function __construct(){}

    public function getAllUsers()
    {
        if (!file_exists($this->jsonFile)) {
            return [];
        }

        $jsonContent = file_get_contents($this->jsonFile); //exiting PHP functions -> retrieves a string
        $data = json_decode($jsonContent, true); // existing PHP function  -> decodes THE string 
        // true: turns the string into and array  -> $task['name']

        return isset($data['users']) ? $data['users'] : [];

    }

    public function addUser(string $name, string $surname, string $password, 
    string $email, UserType $type)
    {
        $users = $this->getAllUsers();

        // Create a new users array
        $newUser = [
            'id_task' => count($users) + 1, 
            'name' => $name,
            'surname' => $surname,
            'password' => $password,
            'email' => $email,
            'type' => $type->value,
            'creation_date' => (new DateTime())->format('Y-m-d H:i:s')
            
        ];

        // Append the new user to the users array
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
            return $users['id_user'] !== $id_user;
        });

        // Save the updated tasks array back to the JSON file
        $data = ['users' => $users];
        file_put_contents($this->jsonFile, json_encode($data, JSON_PRETTY_PRINT));
    }
}


?>