<?php

namespace MyMusic\View;

class ViewRenderer extends \ArrayObject
{
    protected $path;
    
    public function __construct($path) {
        $this->path = $path;
    }
    
    public function includeScript($script) {
        include $this->path . '/' . $script;
    }

}