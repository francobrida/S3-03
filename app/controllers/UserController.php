<?php

class UserController extends ApplicationController
{
    protected User $user;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) { 
            session_start();
        }
        $this->user = UserFactory::create();
    }
    
    public function indexAction() : void 
    {
       if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''){ 
            $_SESSION['info_message'] = "Ya tienes una sesión iniciada.";
            header("Location: " . $this->_baseUrl() . "/task");
            exit;
        }
    }

    public function adminAction() : void 
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
        
        header("Location: " . $this->_baseUrl() . "/user-admin");
        exit;
    }

    public function deleteAction() : void 
    {    
        $id_to_delete = $this->_getParam('id');
        $current_user_id = $_SESSION['user_id'];

        if ($current_user_id == $id_to_delete) {
            $_SESSION['error'] = "You cannot delete your own account while logged in.";
        } else {
            $this->user->deleteUser($id_to_delete);
            $_SESSION['success'] = "User deleted successfully.";
        }

        header("Location: " . $this->_baseUrl() . "/user-admin");
        exit;
    }

    public function editAction() : void 
    {
        $id_user = $this->_getParam('id');

        $foundUser = $this->user->searchUser((int)$id_user); 
        
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
        
        header("Location: " . $this->_baseUrl() . "/user-admin");
        exit;
    }

   public function loginAction() : void 
   {
        $foundUser = $this->user->authenticateUser($this->_getParam('nickname'), $this->_getParam('password'));

        if ($foundUser) {
            $_SESSION['user_id'] = $foundUser['id'];
            $_SESSION['nickname'] = $foundUser['nickname'];
            $_SESSION['type'] = $foundUser['type'];

            header("Location: " . $this->_baseUrl() . "/task"); 
            exit; 
        } else {
            $_SESSION['error'] = "Nickname/password incorrect";

            header("Location: " . $this->_baseUrl() . "/index"); 
            exit;
        }
   }

   public function logoutAction() : void {
        session_unset();
        session_destroy();

        header("Location: " . $this->_baseUrl() . "/index"); 
        exit;
   }

    public function registerAction(): void 
    {
        $nickname = $this->_getParam('nickname');

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
      $searchByNickname = $_GET['search'] ?? ''; 
    
      $this->view->users = $this->user->filterUser($searchByNickname);

      $this->view->render('user/admin.phtml');
      exit;

    }
    
}