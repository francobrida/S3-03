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
	'/category' => 'category#index',
	'/category/add' => 'category#add',
	'/user' => 'user#index',
	'/user/add' => 'user#add',
	'/user/delete' => 'user#delete'
);
