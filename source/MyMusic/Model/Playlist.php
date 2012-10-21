<?php

namespace MyMusic\Model;

class Playlist
{
    protected $id, $name;
    
    /** @var Track[] */
    protected $tracks;
    
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

    public function setTracks($tracks)
    {
        $this->tracks = $tracks;
    }

    public function getTracks()
    {
        if ($this->tracks instanceof \Closure) {
            $this->tracks = call_user_func($this->tracks);
        }
        return $this->tracks;
    }
}