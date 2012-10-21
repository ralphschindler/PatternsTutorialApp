<?php

namespace MyMusic\Model;

interface PlaylistRepositoryInterface
{
    /** @return Playlist[] */
    public function findAllPlaylists();
}