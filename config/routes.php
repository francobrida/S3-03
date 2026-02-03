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
	'/index' => 'test#index',
	'/test' => 'test#index',
	'/task' => 'task#index',
	'/task/addTask' => 'task#addTask',
	'/task/deleteTask' => 'task#deleteTask',
	'/task/editTask' => 'task#editTask',
	'/task/updateTask' => 'task#updateTask',
	'/category' => 'category#index',
	'/category/add' => 'category#add',
	'/category/delete' => 'category#delete',
	'/category/edit' => 'category#edit',
	'/category/update' => 'category#update',
	'/user' => 'user#index',
	'/user/add' => 'user#add',
	'/user/delete' => 'user#delete',
	'/user/edit' => 'user#edit',
	'/user/update' => 'user#update'
);
