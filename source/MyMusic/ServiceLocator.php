<?php

namespace MyMusic;

use \Zend\Db\Adapter\Adapter as DbAdapter;

class ServiceLocator implements \ArrayAccess
{
    
    protected $services;
    
    public function __construct()
    {
        $this->services = $this->initialize();
    }
    
    public function offsetGet($name)
    {
        $name = str_replace(array('-', '_', ' '), '', strtolower($name));
        if (!isset($this->services[$name])) {
            throw new \InvalidArgumentException('A service by that name does not exist.');
        }
        if ($this->services[$name] instanceof \Closure) {
            $service = $this->services[$name];
            $this->services[$name] = $service($this);
        }
        return $this->services[$name];
    }
    
    public function offsetSet($name, $value)
    {
        $name = str_replace(array('-', '_', ' '), '', strtolower($name));
        if (isset($this->services[$name])) {
            throw new \InvalidArgumentException('A service by that name already exist.');
        }
        $this->services[$name] = $value;
    }
    
    public function offsetExists($name)
    {
        $name = str_replace(array('-', '_', ' '), '', strtolower($name));
        return array_key_exists($this->services, $name);
    }
    
    public function offsetUnset($name)
    {
        $name = str_replace(array('-', '_', ' '), '', strtolower($name));
        unset($this->services[$name]);
    }
    
    protected function initialize()
    {
        return array(
            
            // database service
            'db' => function ($services) {
                $config = $services['config'];
                $db = new DbAdapter(array(
                    'driver' => 'Pdo_Sqlite',
                    'database' => $config['db.file'],
                    'options' => array(
                        'buffer_resultset' => true
                    )
                ));
                return $db;
            },
            
            // view service
            'viewrenderer' => function ($services) {
                return new View\ViewRenderer(APP_ROOT . '/resource/view');
            },
            
            'playlistrepository' => function ($services) {
                return new Model\PlaylistRepository(
                    new Model\DataMapper($services['db'])
                );
            },
        );
    }
    
}