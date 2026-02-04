<?php

class UserController extends ApplicationController
{
    protected User $user;

    public function __construct()
    {
        $this->user = new User();
    }
    
    public function indexAction() : void
    {
        $this->view->users = $this->user->getAllUsers();  
    }

    public function addAction() : void {
    
        $nickname = $this->_getParam('nickname');

        // Validation to Check if nickname is already used. In real life also should validate email.
        if ($this->user->isAlreadyUsed($nickname)) {
            $_SESSION['error'] = "The nickname '$nickname' is already used. Please choose another.";
            header("Location: " . $this->_baseUrl() . "/user/index");
            exit;
        }

        $nickname = $this->_getParam('nickname');
        $name = $this->_getParam('name');
        $surname = $this->_getParam('surname');
        $password = $this->_getParam('password');
        $email = $this->_getParam('email');
        $type = $this->_getParam('type');
        
        $this->user->addUser($nickname, $name, $surname, $password, $email, UserType::from($type));
        
        header("Location: " . $this->_baseUrl() . "/user");
        exit;
    }

    public function deleteAction() : void {
        $id_user = $this->_getParam('id');

        $this->user->deleteUser($id_user);
        
        header("Location: " . $this->_baseUrl() . "/user");
        exit;
    }

     public function editAction() : void {
        $id_user = $this->_getParam('id');

        $foundUser = $this->user->searchUser((int)$id_user); // casting to int, if not it's a string 
        
        $this->view->user = $foundUser;
    }

    public function updateAction() : void {

        $id = $this->_getParam('id');
        $nickname = $this->_getParam('nickname');
        $name = $this->_getParam('name');
        $surname = $this->_getParam('surname');
        $password = $this->_getParam('password');
        $email = $this->_getParam('email');
        $type = $this->_getParam('type');

        $this->user->editUser((int)$id, $nickname, $name, $surname, $password, $email, UserType::from($type));
        
        header("Location: " . $this->_baseUrl() . "/user");
        exit;
    }

   public function loginAction() : void {
        session_start(); // To save user info during navigation

        $foundUser = $this->user->authenticateUser($this->_getParam('nickname'), $this->_getParam('password'));

        if ($foundUser) {
            $_SESSION['user_id'] = $foundUser['id'];
            $_SESSION['nickname'] = $foundUser['nickname'];
            $_SESSION['type'] = $foundUser['type'];

            header("Location: " . $this->_baseUrl() . "/task"); // redirect to tasks if succesfull loguin.
            exit; 
        } else {
            $_SESSION['error'] = "Nickname/password incorrect";

            header("Location: " . $this->_baseUrl() . "/user/index"); // redirect to login if wrong loguin.
            exit;
        }
   }

    public function registerAction(): void {
        session_start(); // To save user info during navigation

        $nickname = $this->_getParam('nickname');

        // Validation to Check if nickname is already used
        if ($this->user->isAlreadyUsed($nickname)) {
            $_SESSION['error'] = "The nickname '$nickname' is already used. Please choose another.";
            header("Location: " . $this->_baseUrl() . "/user/index");
            exit;
        }

        $name = $this->_getParam('name');
        $surname = $this->_getParam('surname');
        $password = $this->_getParam('password');
        $email = $this->_getParam('email');
        
        $newUser = $this->user->addUser($nickname, $name, $surname, $password, $email, UserType::Member);
        $_SESSION['user_id'] = $newUser['id'];
        $_SESSION['nickname'] = $newUser['nickname'];
        $_SESSION['type'] = $newUser['type'];

        header("Location: " . $this->_baseUrl() . "/task");
        exit;
    }

}