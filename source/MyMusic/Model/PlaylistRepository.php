<?php

namespace MyMusic\Model;

class PlaylistRepository
{
    
    protected $dataMapper = null;
    
    public function __construct(DataMapper $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }
    
    /** @return Playlist[] */
    public function findByName($name)
    {
        //$playlists = $this->dataMapper->findBy(array('name' => $name));
        
    }

    public function store(Playlist $playlist)
    {
        $this->dataMapper->savePlaylist($playlist);
    }
}
