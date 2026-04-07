<?php

interface UserStorageInterface {
    public function getAll(): array;
    public function saveData(array $data) : void;
    public function readData() : array;
    public function deleteData(int $id) : bool;
    public function searchData(int $id) : ?array;  
    public function addUser(string $nickname, string $name, string $surname, string $password, string $email, UserType $type) : array;  
    public function editUser(int $id_user, string $nickname, string $name, string $surname, 
                             string $password, string $email, UserType $type) : void;
    public function authenticateUser(string $nickname, string $password) : ?array;
    public function isAlreadyUsed(string $nickname) : bool;
    public function filterUser(string $searchByNickname) : array;
    
}

?>