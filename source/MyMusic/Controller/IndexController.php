<?php

namespace MyMusic\Controller;

class IndexController {
    public function indexAction($services) {

        /** @var $view \MyMusic\View\ViewRenderer */
        $view = $services['viewrenderer'];

        /** @var $playlistRepo \MyMusic\Model\PlaylistService */
        $playlistRepo = $services['PlaylistService'];
        $view->playlists = $playlistRepo->findAll();

        $view->includeScript('index/index.phtml');
    }
}