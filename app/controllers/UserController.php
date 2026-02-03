<?php

class UserController extends ApplicationController
{
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
}