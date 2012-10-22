<?php

namespace MyMusic\Controller;

class PlaylistController {
    public function listAction($services) {

        /** @var $view \MyMusic\View\ViewRenderer */
        $view = $services['viewrenderer'];

        /** @var $playlistRepo \MyMusic\Model\PlaylistRepository */
        $playlistRepo = $services['PlaylistRepository'];

        $view->playlist = $playlistRepo->findById($_GET['playlist']);
        $view->includeScript('playlist/list.phtml');
    }
}