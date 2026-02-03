<?php

class UserController extends ApplicationController
{
    /*
    public function __construct(User $user = new User())
    {}
    */
    
    public function indexAction() : void
    {
        $users = new User(); 
        $this->view->users = $users->getAllUsers();  

    }

    public function addAction() : void {
    
        $nickname = $this->_getParam('nickname');
        $name = $this->_getParam('name');
        $surname = $this->_getParam('surname');
        $password = $this->_getParam('password');
        $email = $this->_getParam('email');
        $type = $this->_getParam('type');
        
        $newUser = new User(); 
        $newUser->addUser($nickname, $name, $surname, $password, $email, UserType::from($type));
        
        header("Location: " . $this->_baseUrl() . "/user");
        exit;
    }

    public function deleteAction() : void {
        $id_user = $this->_getParam('id');

        $userModel = new User(); 
        $userModel->deleteUser($id_user);
        
        header("Location: " . $this->_baseUrl() . "/user");
        exit;
    }

     public function editAction() : void {
        $id_user = $this->_getParam('id');

        $userModel = new User(); 
        $foundUser = $userModel->searchUser((int)$id_user); // casting to int, if not it's a string 
        
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
        
        $userModel = new User(); 

        $userModel->editUser((int)$id, $nickname, $name, $surname, $password, $email, UserType::from($type));
        
        header("Location: " . $this->_baseUrl() . "/user");
        exit;
    }
}