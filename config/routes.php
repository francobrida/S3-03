<?php 

/**
 * Used to define the routes in the system.
 * 
 * A route should be defined with a key matching the URL and an
 * controller#action-to-call method. E.g.:
 * 
 * '/' => 'index#index',
 * '/calendar' => 'calendar#index'
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

    // Root route:"Landing Page" (Login/Register)
    '/index' => 'user#index',
    
    // Login: route to authenticate user and create session
    '/login' => 'user#login',
    
    // Register: route to create a new user as member
    '/register' => 'user#register',
    
    // Logout: Clear session and redirect to home
    '/logout' => 'user#logout'
);
