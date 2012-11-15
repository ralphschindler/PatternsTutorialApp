<?php

namespace MyMusic\Controller;

use MyMusic\Model\Playlist;

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

        Playlist::registerDbAdapter($services['db']);
        $view->playlists = Playlist::findAll();
        $view->playlist = Playlist::findByIdWithRelationships($_GET['playlist']);

        $view->includeScript('playlist/list.phtml');
    }
}
