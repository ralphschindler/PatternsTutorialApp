<?php

namespace MyMusic\Model;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\TableGateway\TableGateway;

/**
 * ActiveRecord Pattern
 */
class Playlist
{
    protected static $dbAdapter;
    protected $rowData;

    public static function registerDbAdapter(DbAdapter $dbAdapter)
    {
        self::$dbAdapter = $dbAdapter;
    }

    /** @return Playlist[] */
    public static function findAll()
    {
        $playlistTable = new TableGateway('playlist', self::$dbAdapter);
        $playlistResult = $playlistTable->select();
        $objs = array();
        foreach ($playlistResult as $row) {
            $objs[] = new self((array) $row);
        }
        return $objs;
    }

    /** @return Playlist */
    public static function findByIdWithRelationships($id)
    {
        $playlistTable = new TableGateway('playlist', self::$dbAdapter);

        $playlistResult = $playlistTable->select(array('id' => $id));
        $playlistData = $playlistResult->current();


        // get tracks via joins
        $trackselect = $playlistTable->getSql()->select();
        $trackselect->join('playlist_track', 'playlist_track.playlist_id = playlist.id', array());
        $trackselect->join('track', 'track.id = playlist_track.track_id', array('track_title' => 'title'));
        $trackselect->join('artist', 'track.artist_id = artist.id', array('artist_name' => 'name'));
        $trackselect->join('album', 'track.album_id = album.id', array('album_title' => 'title'));

        // get data
        $playlistTrackResult = $playlistTable->selectWith($trackselect);
        $tracks = array();
        foreach ($playlistTrackResult as $trackRow) {
            $tracks[] = new \ArrayObject($trackRow, \ArrayObject::ARRAY_AS_PROPS);
        }

        $playlistData['tracks'] = $tracks;

        return new self($playlistData);
    }


    public function __construct($rowData)
    {
        $this->rowData = $rowData;
    }

    public function __get($name)
    {
        return $this->rowData[$name];
    }

    public function save()
    {
        throw new \Exception('Not yet implemented');
    }

    public function delete()
    {
        throw new \Exception('Not yet implemented');
    }

}
