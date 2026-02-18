<?php

require_once 'Adapters/UserSQL.php';
require_once 'Adapters/UserJSON.php';

class User {

    private $adapter;

    public function __construct() 
    {
        // PERSISTENCE switch
        // Switch between new UserSQL() and new UserJSON() to change persistance.
        $this->adapter = new UserSQL(); 
        //$this->adapter = new UserJSON(); 
    }

    public function getAllUsers() : array
    {
        return $this->adapter->getAll();
    }

    public function addUser(string $nickname, string $name, string $surname, string $password, string $email, UserType $type) : array
    {
        return $this->adapter->addUser($nickname, $name, $surname, $password, $email, $type);
    }

    public function deleteUser(int $id_user) : bool
    {
        return $this->adapter->deleteData($id_user);
    }

    public function searchUser(int $id_user) : ?array
    {
        return $this->adapter->searchData($id_user);
    }

    public function editUser(int $id_user, string $nickname, string $name, string $surname, 
                             string $password, string $email, UserType $type) : void
    {
        $this->adapter->editUser($id_user, $nickname, $name, $surname, $password, $email, $type);
    }

    public function authenticateUser(string $nickname, string $password) : ?array 
    {
        return $this->adapter->authenticateUser($nickname, $password);
    }

    public function isAlreadyUsed(string $nickname) : bool 
    {
        return $this->adapter->isAlreadyUsed($nickname);
    }

    public function filterUser(string $searchByNickname) : array 
    {
        return $this->adapter->filterUser($searchByNickname);
    }
}