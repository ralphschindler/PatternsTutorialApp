<?php

namespace MyMusic\Model;

/**
 * @pattern-notes
 *
 * An implementation of the PlaylistRepositoryInterface
 *
 * This one is database driven, and as you can see in the
 * constructor, it consumes a DataMapper.
 */
class PlaylistRepository implements PlaylistRepositoryInterface
{
    /** @var DataMapper */
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

    public function store(Playlist $playlist)
    {
        $this->dataMapper->savePlaylist($playlist);
    }

}
