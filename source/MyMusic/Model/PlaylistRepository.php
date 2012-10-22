<?php

namespace MyMusic\Model;

class PlaylistRepository implements PlaylistRepositoryInterface
{
    
    protected $dataMapper = null;
    
    public function __construct(DataMapper $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    public function findAll()
    {
        return $this->dataMapper->findPlaylists();
    }

    public function findById($id)
    {
        // find by id will always return 0 or 1
        $playlists = $this->dataMapper->findPlaylistBy(array('id' => $id));
        if ($playlists) {
            return $playlists[0];
        } else {
            return false;
        }
    }

    /** @return Playlist[] */
    public function findByName($name)
    {
    }

    public function store(Playlist $playlist)
    {
        $this->dataMapper->savePlaylist($playlist);
    }

}
