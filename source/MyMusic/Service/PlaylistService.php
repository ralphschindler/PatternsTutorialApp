<?php

namespace MyMusic\Service;

use MyMusic\Model\PlaylistRepositoryInterface;

class PlaylistService
{
    protected $playlistRepo;

    public function __construct(PlaylistRepositoryInterface $playlistRepo)
    {
        $this->playlistRepo = $playlistRepo;
    }

    public function findAll()
    {
        return $this->playlistRepo->findAll();
    }

    public function findOneById($id)
    {
        return $this->playlistRepo->findById($id);
    }

}
