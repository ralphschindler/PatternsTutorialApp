<?php

namespace MyMusic\Model;

/**
 * Repository Pattern
 *
 * - This object is "persistence" ignorant
 *
 * @link http://martinfowler.com/eaaCatalog/repository.html
 * @link https://www.google.com/search?q=repository+pattern+ddd
 */
interface PlaylistRepositoryInterface
{

    /** @return Playlist[] */
    public function findAll();

    /** @return Playlist */
    public function findById($id);

    public function store(Playlist $playlist);

}
