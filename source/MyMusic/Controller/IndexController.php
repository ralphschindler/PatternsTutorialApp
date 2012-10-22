<?php

namespace MyMusic\Controller;

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

        /** @var $playlistRepo \MyMusic\Service\PlaylistService */
        $playlistRepo = $services['PlaylistService'];

        /**
         * @pattern-notes
         *
         * We know that findAll() returns an object that is an "Iterator",
         * or is iterable, our view will iterate it
         */
        $view->playlists = $playlistRepo->findAll();

        $view->includeScript('index/index.phtml');
    }
}