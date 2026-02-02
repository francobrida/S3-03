<?php

class UserController extends ApplicationController
{
    public function userAction()
    {
        $users = new User(); //create user instance

        $this->view->users = $users->getAllUsers(); //shows all           
    }
}