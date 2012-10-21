<?php

define('APP_ROOT', __DIR__);

// autoload app classes
spl_autoload_register(function($class) {
    if (strpos($class, 'MyMusic') === 0) return include APP_ROOT . '/source/' . str_replace('\\', '/', $class) . '.php';
});

// vendor includes
include APP_ROOT . '/vendor/Zend_Db-2.0.3.phar';
include APP_ROOT . '/vendor/SpotifyAPI/autoload.php';

// services
$services = new MyMusic\ServiceLocator;
$services['config'] = parse_ini_file(APP_ROOT . '/data/config.ini');