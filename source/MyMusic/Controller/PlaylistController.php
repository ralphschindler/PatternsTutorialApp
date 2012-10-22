<?php

namespace MyMusic\Controller;

/**
 * @pattern-notes
 *
 * - This is Controller (The C in the MVC)
 *
 * - It is the bridge between the environment and your models (or services)
 */
class PlaylistController
{

    /**
     * @pattern-notes
     *
     * - consumes a service locator object, fulfilling the service location pattern
     *
     * @param $services \MyMusic\ServiceLocator The service locator (injected)
     */
    public function listAction($services)
    {
        /** @var $view \MyMusic\View\ViewRenderer */
        $view = $services['viewrenderer'];

        /** @var $playlistRepo \MyMusic\Service\PlaylistService */
        $playlistRepo = $services['PlaylistService'];
        $view->playlist = $playlistRepo->findOneById($_GET['playlist']);

        $view->includeScript('playlist/list.phtml');
    }
}
