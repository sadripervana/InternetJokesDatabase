<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
	include __DIR__ . '/includes/autoload.php';

	$route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

	$entryPoint = new \Framework\EntryPoint($route,$_SERVER['REQUEST_METHOD'], new \Ijdb\IjdbRoutes());
	$entryPoint->run();
	
} 
catch (PDOException $e) {
	$title = 'An error has occurred';
	$output = 'Database error: ' . 
	$e->getMessage() . ' in ' . 
	$e->getFile() . ':' . 
	$e->getLine();

	include __DIR__ . '/templates/layout.html.php';
}