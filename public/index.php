<?php

include __DIR__ . '/../application.php';

$controller = ucwords(isset($_GET['controller']) ? $_GET['controller'] : 'index');
$controller = 'MyMusic\Controller\\' . $controller . 'Controller';
$controller = new $controller;

$action     = isset($_GET['action']) ? $_GET['action'] : 'index';
$controller->{$action . 'Action'}($services);
