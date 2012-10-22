<?php

namespace MyMusic\Model;

interface PlaylistRepositoryInterface
{

    /** @return Playlist[] */
    public function findAll();

    /** @return Playlist */
    public function findById($id);

}
