<?php

class UserSQL extends Model implements StorageInterface {
   

    public function __construct()
    {
        parent::__construct(); 
    }

    
    public function init()
    {
        $this->_setTable('users'); 
    }

    public function getAll() : array
    {   
        return $this->readData();
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

        $id = $this->save($newUser); 
        $newUser['id'] = $id; 
        
        
        return $newUser;
    }

    public function deleteData(int $id_user) : bool
    {
        $sqlTasks = "DELETE FROM tasks WHERE user_id = ?";
        $queryTasks = $this->_dbh->prepare($sqlTasks);
        $queryTasks->execute([$id_user]);

        return $this->delete($id_user); 
    }

    public function searchData(int $id_user) : ?array 
    {
        $user = $this->fetchOne($id_user);
        if (!$user){
            return null;
        }
        return (array) $user; 
    }

    public function editUser(int $id_user, string $nickname, string $name, string $surname, 
    string $password, string $email, UserType $type) : void
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

        $this->saveData($updated);

    }

   public function authenticateUser(string $nickname, string $password) : ?array 
    {
        $user = "SELECT * FROM users WHERE nickname = ?";
        $query = $this->_dbh->prepare($user);
        $query->execute([$nickname]);
        
        $userFound = $query->fetch(PDO::FETCH_ASSOC);

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

    public function readData() : array
    {
        $this->_setTable('users');
        $sql = "SELECT * FROM users";
        $statement = $this->_dbh->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveData(array $dataToSave) : void
    {
        $this->save($dataToSave);
    }

}

?>