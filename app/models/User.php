<?php

class User {

    public function __construct(
        private int $id,
        private string $name,
        private string $surname,
        private string $password,
        private string $email,
        private UserType $type,
        private Datetime $creation_date
    ){}

    public function getId() : int {return $this->id;}
    public function getName() : string {return $this->name;}
    public function getSurname() : string {return $this->surname;}
    public function getPassword() : string {return $this->password;}
    public function getType() : UserType {return $this->type;}
    public function getCreation_date() : Datetime {return $this->creation_date;}
    public function getEmail() : string {return $this->email;}

    public function setName(string $name) : void {$this->name = $name;}
    public function setSurname(string $surname) : void {$this->surname = $surname;}
    public function setType(UserType $type) : void {$this->type = $type;}
    public function setPassword(string $password) : void {$this->password = $password;}
    public function setEmail(string $email) : void {$this->email = $email;}
    // All setters except id and cration_date

}

?>