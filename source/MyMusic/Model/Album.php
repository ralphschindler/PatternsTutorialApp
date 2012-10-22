<?php

namespace MyMusic\Model;

/**
 * @pattern-notes
 *
 * - This is an entity class
 */
class Album
{
    protected $id;
    protected $title;
    protected $releaseDate;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }

    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

}