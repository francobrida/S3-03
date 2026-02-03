<?php

class UserController extends ApplicationController
{
    public function indexAction()
    {
        $users = new User(); 
        $this->view->users = $users->getAllUsers();  
                 
    }
}