<?php 

/**
 * Used to define the routes in the system.
 * 
 */
$routes = array(
	'/test' => 'test#index',
	
	// TASK 
    '/task' => 'task#index',
    '/task/addTask' => 'task#addTask',
    '/task/addNewTask' => 'task#addNewTask',
    '/task/deleteTask' => 'task#deleteTask',
    '/task/editTask' => 'task#editTask',
    '/task/updateTask' => 'task#updateTask',
    '/task/filter' => 'task#filter',

    // CATEGORY 
    '/category' => 'category#index',
    '/category/add' => 'category#add',
    '/category/delete' => 'category#delete',
    '/category/edit' => 'category#edit',
    '/category/update' => 'category#update',
    '/category/filter' => 'category#filter',

    // USER 
    '/userAdmin' => 'user#admin',
    '/user/addView' => 'user#addView',
    '/user/add' => 'user#add',
    '/user/delete' => 'user#delete',
    '/user/edit' => 'user#edit',
    '/user/update' => 'user#update',
    '/user/filter' => 'user#filter',

    '/index' => 'user#index',
    
    '/login' => 'user#login',
    
    '/register' => 'user#register',
    
    '/logout' => 'user#logout'
);
