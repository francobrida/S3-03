<?php

class UserController extends ApplicationController
{
    protected User $user;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) { // If session isn't started...
            session_start();// Start session to save user info during navigation
        }
        $this->user = new User();
    }
    
    public function indexAction() : void // Landing page
    {
       if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''){ 
            $_SESSION['info_message'] = "Ya tienes una sesión iniciada. Haz logout si eres otro usuario, sorry not sorry ;)";
            header("Location: " . $this->_baseUrl() . "/task");
            exit;
        }
    }

    public function adminAction() : void // User Admin page
    {
        
        if (isset($_SESSION['user_id']) && $_SESSION['type'] != 'Admin'){
            $_SESSION['info_message'] = "No puedes acceder a este panel si no eres Admin";
            header("Location: " . $this->_baseUrl() . "/task");
            exit;
        }
        $this->view->users = $this->user->getAllUsers(); 
    }

    public function addViewAction() : void {}

    public function addAction() : void 
    {
    
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
        
        header("Location: " . $this->_baseUrl() . "/userAdmin");
        exit;
    }

    public function deleteAction() : void 
    {
        $id_user = $this->_getParam('id');

        $this->user->deleteUser($id_user);
        
        header("Location: " . $this->_baseUrl() . "/userAdmin");
        exit;
    }

    public function editAction() : void 
    {
        $id_user = $this->_getParam('id');

        $foundUser = $this->user->searchUser((int)$id_user); // casting to int
        
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
        
        header("Location: " . $this->_baseUrl() . "/userAdmin");
        exit;
    }

   public function loginAction() : void 
   {
        $foundUser = $this->user->authenticateUser($this->_getParam('nickname'), $this->_getParam('password'));

        if ($foundUser) {
            $_SESSION['user_id'] = $foundUser['id'];
            $_SESSION['nickname'] = $foundUser['nickname'];
            $_SESSION['type'] = $foundUser['type'];

            header("Location: " . $this->_baseUrl() . "/task"); // redirect to tasks if succesfull loguin.
            exit; 
        } else {
            $_SESSION['error'] = "Nickname/password incorrect";

            header("Location: " . $this->_baseUrl() . "/index"); // redirect to login if wrong loguin.
            exit;
        }
   }

   public function logoutAction() : void {
        session_unset();
        session_destroy();

        header("Location: " . $this->_baseUrl() . "/index"); // redirects to landing page
        exit;
   }

    public function registerAction(): void 
    {

        $nickname = $this->_getParam('nickname');

        // Validation to Check if nickname is already used
        if ($this->user->isAlreadyUsed($nickname)) {
            $_SESSION['error'] = "El nickname '$nickname' ya está ocupado. Por favor elija otro.";
            header("Location: " . $this->_baseUrl() . "/index");
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

    public function filterAction() : void 
    {
      $searchByNickname = $_GET['search'] ?? ''; /* This is just an example, in real life should 
      validate/sanitize this input to avoid security issues */
    
      $this->view->users = $this->user->filterUser($searchByNickname);

      $this->view->render('user/admin.phtml');
      exit;

    }
    
}