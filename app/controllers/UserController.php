<?php

class UserController extends ApplicationController
{
    public function indexAction()
    {
        $users = new User(); //create user instance

        $this->view->users = $users->getAllUsers(); //shows all           
    }
}