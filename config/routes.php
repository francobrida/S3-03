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

    // USER (Admin)
    '/userAdmin' => 'user#admin',
    '/userAddView' => 'user#addView',
    '/user/add' => 'user#add',
    '/user/delete' => 'user#delete',
    '/user/edit' => 'user#edit',
    '/user/update' => 'user#update',

    // Esta parte nueva la explico en castellano hasta que la tengamos super claro para no liarnos (Fran)
    
    // Root route: Pagina principal de entrada! "Landing Page" (Login/Register)
    '/index' => 'user#index',
    
    // Login: Ruta que envia el nickname y password para loguearse
    '/login' => 'user#login',
    
    // Register: Registra nuevo usuario (Público - se crea automaticamente como Type::Member)
    '/register' => 'user#register',
    
    // Logout: Clear session and redirect to home (TO DO, si tenemos login, necesitamos un logout)
    '/logout' => 'user#logout'
);
