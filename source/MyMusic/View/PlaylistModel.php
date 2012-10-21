<?php

namespace MyMusic\View;

use MyMusic\Controller\PlaylistRepositoryInterface;

class PlaylistModel implements \IteratorAggregate
{
    protected $playlistRepo;
    
    public function __constrct(PlaylistRepositoryInterface $playlistRepo)
    {
        $this->playlistRepo = $playlistRepo;
    }
    
    public function getIterator()
    {
        return new \ArrayIterator($this->playlistRepo->findAllPlaylists());
    }
    
}