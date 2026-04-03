<?php 

$routes = array(
	'/test' => 'test#index',
	
	// TASK 
    '/task' => 'task#index',
    '/task/add-task' => 'task#addTask',
    '/task/add-new-task' => 'task#addNewTask',
    '/task/delete-task' => 'task#deleteTask',
    '/task/edit-task' => 'task#editTask',
    '/task/update-task' => 'task#updateTask',
    '/task/filter' => 'task#filter',

    // CATEGORY 
    '/category' => 'category#index',
    '/category/add' => 'category#add',
    '/category/delete' => 'category#delete',
    '/category/edit' => 'category#edit',
    '/category/update' => 'category#update',
    '/category/filter' => 'category#filter',

    // USER 
    '/user-admin' => 'user#admin',
    '/user/add-view' => 'user#addView',
    '/user/add' => 'user#add',
    '/user/delete' => 'user#delete',
    '/user/edit' => 'user#edit',
    '/user/update' => 'user#update',
    '/user/filter' => 'user#filter',

    // AUTH
    '/' => 'user#index', 
    '/index' => 'user#index',
    '/login' => 'user#login',
    '/register' => 'user#register',
    '/logout' => 'user#logout'
);
