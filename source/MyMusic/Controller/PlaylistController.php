<?php

namespace MyMusic\Controller;

class PlaylistController
{
    public function listAction($services)
    {
        /** @var $view \MyMusic\View\ViewRenderer */
        $view = $services['viewrenderer'];

        /** @var $playlistRepo \MyMusic\Model\PlaylistService */
        $playlistRepo = $services['PlaylistService'];
        $view->playlist = $playlistRepo->findOneById($_GET['playlist']);

        $view->includeScript('playlist/list.phtml');
    }
}
