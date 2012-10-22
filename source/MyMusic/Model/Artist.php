<?php

namespace MyMusic\Model;

/**
 * @pattern-notes
 *
 * - This is an entity class
 */
class Artist
{
    protected $id;
    protected $name;
    protected $history;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setHistory($history)
    {
        $this->history = $history;
    }

    public function getHistory()
    {
        return $this->history;
    }

}
