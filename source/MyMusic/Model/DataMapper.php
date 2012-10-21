<?php

namespace MyMusic\Model;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\TableGateway\TableGateway;

class DataMapper
{
    protected $dbAdapter;
    protected $playlistTable;

    public function __construct(DbAdapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;

    }
    
    public function findPlaylistBy(array $info)
    {
        $playlistTg = new TableGateway('playlist', $this->dbAdapter);
        $rowset = $playlistTg->select($info);
        $playlists = array();
        foreach ($rowset as $row) {
            $playlists[] = $this->mapPlaylistRowToObject($row);
        }
        return $playlists;
    }

    public function savePlaylist(Playlist $playlist)
    {
        $row = array(
            'id' => $playlist->getId(),
            'name' => $playlist->getName()
        );
        $playlistTg = new TableGateway('playlist', $this->dbAdapter);
        if ($row['id']) {
            $rowset = $playlistTg->select(array('id' => $row['id']));
            if ($rowset->count() == 1) {
                $playlistTg->update($row, array('id' => $row['id']));
            } else {
                $playlistTg->insert($row);
                $id = $playlistTg->getLastInsertValue();
            }
        }

    }

    public function saveTrack(Track $track)
    {

    }

    public function saveArtist(Artist $artist)
    {

    }

    public function saveAlbum(Album $album)
    {

    }

    protected function mapPlaylistRowToObject(array $row)
    {
        $playlist = new Playlist;
        $playlist->setId($row['id']);
        $playlist->setName($row['name']);
        $playlist->setTracks($this->lazyLoadTracksClosure($row['id']));
        return $playlist;
    }

    protected function lazyLoadTracksClosure($playlistId)
    {
        return function () use ($playlistId) {
            
        };
    }
    
}