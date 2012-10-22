<?php

namespace MyMusic\Model;

/**
 * @pattern-notes
 *
 * - This is an entity class
 *
 * - This is actually our Aggregate Root
 */
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

    /**
     * @param \Closure|array $tracks
     */
    public function setTracks($tracks)
    {
        $this->tracks = $tracks;
    }

    /**
     * @pattern-notes
     *
     * - This returns our aggregation (of tracks)
     *
     * - Pragmatism: this uses php closures to implement lazy-loading,
     *   another way of doing this would be to have a TrackCollection
     *   that is capable of loading on demand.  You choose.
     *
     * @return Track[]
     */
    public function getTracks()
    {
        if ($this->tracks instanceof \Closure) {
            $this->tracks = call_user_func($this->tracks);
        }
        return $this->tracks;
    }
}