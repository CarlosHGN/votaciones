<?php
date_default_timezone_set('America/Santiago');

// CRUD MVC // Cored developed by Carlos H. Gonzalez N.
include_once 'config/Config.php';
include_once 'methods/Controller.php';
include_once 'methods/Router.php';
include_once 'class/Elections.class.php';
include_once 'class/Database.class.php';

session_name(SESSIONNAME);
session_set_cookie_params(
	time()+3600,
	WEBSITEPATH,
	$_SERVER['HTTP_HOST']
);

if (!isset($_GET['pg'])) {
	$pg='formulario';
}else{
	$pg = filter_input(INPUT_GET, 'pg', $filter = FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

$router = new Router();
if($router->validGET($pg)){
	$router->chargeViews($pg);
}
