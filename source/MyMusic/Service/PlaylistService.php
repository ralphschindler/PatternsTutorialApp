<?php

namespace MyMusic\Service;

use MyMusic\Model\PlaylistRepositoryInterface;

/**
 * This is a "Service Layer" class
 *
 * An abstraction layer between controllers and your models
 *
 * You might do this so that your services are portable between
 * different kinds of applications (think an API/web-service
 * centric application)
 */
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
