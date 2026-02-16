<?php
require_once __DIR__ . '/../../lib/base/Model.php';
require_once 'UserType.php';

class User extends Model{
    /*
    // Path to the JSON files storing users and tasks
    protected $jsonUsers = ROOT_PATH . '/data/users.json';
    protected $jsonTasks = ROOT_PATH . '/data/tasks.json';
    */

    public function __construct()
    {
        // 1. Calls the parent constructor to establish the database connection and store it in $this->_dbh
        parent::__construct(); 
    }

    // 2. We use init to set the table name
    public function init()
    {
        $this->_setTable('users'); 
    }

    public function getAllUsers() : array
    {   /*
        if (!file_exists($this->jsonUsers)) {
            return [];
        } // If the file doesn't exist, return an empty array (no users)

        $jsonContent = file_get_contents($this->jsonUsers); // Get the content of the JSON file as a string
        $data = json_decode($jsonContent, true);  Decode the JSON string into a PHP array. 
        The second parameter 'true' is important, it tells json_decode to return an associative 
        array instead of an object. So we can access properties like $task['name'] instead of $task->name.

        // Uncomment to debug:
        // die(var_dump($data));

        return isset($data['users']) ? $data['users'] : [];
        */

        $sql = "SELECT * FROM users";
        
        // 1. Prepare
        $preparedQuery = $this->_dbh->prepare($sql);
        
        // 2. Execute
        $preparedQuery->execute();
        
        // 3. We bring the results as an associative array.
        return $preparedQuery->fetchAll(PDO::FETCH_ASSOC);

    }

    public function addUser(string $nickname, string $name, string $surname, string $password, 
    string $email, UserType $type) : array
    {
        $newUser = [
        'nickname' => strtolower($nickname),
        'name' => $name,
        'surname' => $surname,
        'password' => $password,
        'email' => $email,
        'type' => $type->value,
        'creation_date' => date('Y-m-d H:i:s')
        ];

        $id = $this->save($newUser); // save() from Model, will insert the new user into the database and return the new ID.
        $newUser['id'] = $id; // Add the generated ID to the new user array.
        
        return $newUser;
    }

    public function deleteUser(int $id_user) : bool
    {
        $sqlTasks = "DELETE FROM tasks WHERE id_user = ?";
        $queryTasks = $this->_dbh->prepare($sqlTasks);
        $queryTasks->execute([$id_user]);

        // Aprovechamos el método delete() que ya viene en el Model.php base
        return $this->delete($id_user); // devuelve 
    }

    public function searchUser(int $id_user) : ?array // return either the user found or null if not found
    {
        $user = $this->fetchOne($id_user);
        if (!$user){
            return null;
        }
        return (array) $user; // converting object to array
    }

    public function editUser(int $id_user, string $nickname, string $name, string $surname, 
    string $password, string $email, UserType $type) : bool 
    {
        $updated = [
            'id'       => $id_user, 
            'nickname' => strtolower($nickname),
            'name'     => $name,
            'surname'  => $surname,
            'password' => $password,
            'email'    => $email,
            'type'     => $type->value
        ];

        return $this->save($updated);

    }

   public function authenticateUser(string $nickname, string $password) : ?array 
    {
        // 1. Search for the user by nickname in the database.
        $user = "SELECT * FROM users WHERE nickname = ?";
        $query = $this->_dbh->prepare($user);
        $query->execute([$nickname]);
        
        $userFound = $query->fetch(PDO::FETCH_ASSOC);

        // 2. If user exists and the password matches, return the user data. Otherwise, return null.
        if ($userFound && $userFound['password'] === $password) {
            return $userFound;
        }

        return null; 
    }

    public function isAlreadyUsed(string $nickname): bool 
    {   
        $cleanNickname = strtolower(trim($nickname));

        $sql = "SELECT * FROM users WHERE nickname = ?";
        $query = $this->_dbh->prepare($sql);
        $query->execute([$cleanNickname]);
    
        $userId = $query->fetch(PDO::FETCH_ASSOC);
        return $userId ? true : false;
    }

    public function filterUser($searchByNickname) : array 
    {
        $cleanNickname = strtolower(trim($searchByNickname));

        $sql = "SELECT * FROM users WHERE nickname LIKE ?";
        $query = $this->_dbh->prepare($sql);
        $query->execute(['%' . $cleanNickname . '%']);
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>