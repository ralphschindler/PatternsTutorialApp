<?php

namespace MyMusic\Controller;

use MyMusic\Model\Playlist;

/**
 * @patter-notes
 *
 * - This is Controller (The C in the MVC)
 *
 * - It is the bridge between the environment and your models (or services)
 */
class IndexController
{

    /**
     * @param $services \MyMusic\ServiceLocator The service locator (injected)
     */
    public function indexAction($services)
    {
        /** @var $view \MyMusic\View\ViewRenderer */
        $view = $services['viewrenderer'];

        Playlist::registerDbAdapter($services['db']);
        $view->playlists = Playlist::findAll();

        $view->includeScript('index/index.phtml');
    }
}