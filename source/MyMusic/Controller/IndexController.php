<?php

namespace MyMusic\Controller;

use MyMusic\View;

class IndexController {
    public function indexAction($services) {
        $view = $services['viewrenderer'];
        
        $services->get('PlaylistRepository');
        
        $view->playlist = new View\PlaylistModel();
        $view->includeScript('index/index.phtml');
    }
}