<?php

// autoload app classes
spl_autoload_register(function($class) {
    if (strpos($class, 'SpotifyAPI') === 0) return include __DIR__ . '/source/' . str_replace('\\', '/', $class) . '.php';
});