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

    public function findPlaylists()
    {
        $playlistTg = new TableGateway('playlist', $this->dbAdapter);
        $rowset = $playlistTg->select();
        $playlists = array();
        /** @var $row \ArrayObject */
        foreach ($rowset as $row) {
            $playlists[] = $this->mapPlaylistRowToObject($row->getArrayCopy());
        }
        return $playlists;
    }
    
    public function findPlaylistBy(array $info)
    {
        $playlistTg = new TableGateway('playlist', $this->dbAdapter);
        $rowset = $playlistTg->select($info);
        $playlists = array();
        foreach ($rowset as $row) {
            $playlists[] = $this->mapPlaylistRowToObject($row->getArrayCopy());
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
        $isUpdate = false;
        if ($row['id']) {
            $rowset = $playlistTg->select(array('id' => $row['id']));
            if ($rowset->count() == 1) {
                $isUpdate = true;
            }
        }

        if ($isUpdate) {
            $playlistTg->update($row, array('id' => $row['id']));
        } else {
            $playlistTg->insert($row);
            $playlist->setId($playlistTg->getLastInsertValue());
        }

        foreach ($playlist->getTracks() as $track) {
            $playlistTrackTg = new TableGateway('playlist_track', $this->dbAdapter);
            $this->saveTrack($track);
            $playlistTrackTg->insert(array('playlist_id' => $playlist->getId(), 'track_id' => $track->getId()));
        }

    }

    public function saveTrack(Track $track)
    {
        $artist = $track->getArtist();
        $album = $track->getAlbum();

        if ($artist) {
            $artistTg = new TableGateway('artist', $this->dbAdapter);

            $rowset = $artistTg->select(array('name' => $artist->getName()));
            if ($rowset->count() == 1) {
                $row = $rowset->current();
                $artist->setId($row['id']);
            } else {
                $artistTg->insert(array('name' => $artist->getName()));
                $artist->setId($artistTg->getLastInsertValue());
            }
        }

        if ($album) {
            $albumTg = new TableGateway('album', $this->dbAdapter);

            $rowset = $albumTg->select(array('title' => $album->getTitle(), 'artist_id' => $artist->getId()));
            if ($rowset->count() == 1) {
                $row = $rowset->current();
                $album->setId($row['id']);
            } else {
                $albumTg->insert(array(
                    'artist_id' => $artist->getId(),
                    'title' => $album->getTitle(),
                    'release_date' => $album->getReleaseDate()
                ));
                $album->setId($albumTg->getLastInsertValue());
            }
        }

        $row = array(
            'id' => $track->getId(),
            'title' => $track->getTitle(),
            'number' => $track->getNumber(),
            'length' => $track->getLength(),
            'artist_id' => $artist->getId(),
            'album_id' => $album->getId()
        );
        $trackTg = new TableGateway('track', $this->dbAdapter);
        $isUpdate = false;
        if ($row['id']) {
            $rowset = $trackTg->select(array('id' => $row['id']));
            if ($rowset->count() == 1) {
                $isUpdate = true;
            }
        }

        if ($isUpdate) {
            $trackTg->update($row, array('id' => $row['id']));
        } else {
            $trackTg->insert($row);
            $track->setId($trackTg->getLastInsertValue());
        }
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
        $dataMapper = $this; // php 5.3 hack, must be renamed
        return function () use ($playlistId, $dataMapper) {
            static $albums = array(), $artists = array();

            $trackTg = new TableGateway('track', $dataMapper->dbAdapter);
            $artistTg = new TableGateway('artist', $dataMapper->dbAdapter);
            $albumTg = new TableGateway('album', $dataMapper->dbAdapter);


            $rowset = $trackTg->select(function (\Zend\Db\Sql\Select $select) {
                $select->join('playlist_track', 'playlist_track.track_id = track.id', array());
            });
            $tracks = array();
            foreach ($rowset as $row) {
                $data = $row->getArrayCopy();
                $track = new Track;
                $track->setId($row['id']);
                $track->setTitle($row['title']);
                $track->setLength($row['length']);
                $track->setNumber($row['number']);

                if (!array_key_exists($row['artist_id'], $artists)) {
                    $artistRowset = $artistTg->select(array('id' => $row['artist_id']));
                    $artistRow = $artistRowset->current();
                    $artist = new Artist;
                    $artist->setId($artistRow['id']);
                    $artist->setName($artistRow['name']);
                    $artists[$artistRow['id']] = $artist;
                }

                if (!array_key_exists($row['album_id'], $albums)) {
                    $albumRowset = $albumTg->select(array('id' => $row['album_id']));
                    $albumRow = $albumRowset->current();
                    $album = new Album;
                    $album->setId($albumRow['id']);
                    $album->setTitle($albumRow['title']);
                    $album->setReleaseDate($albumRow['release_date']);
                    $albums[$albumRow['id']] = $album;
                }

                $track->setArtist($artists[$row['artist_id']]);
                $track->setAlbum($albums[$row['album_id']]);

                $tracks[] = $track;
            }
            return $tracks;
        };
    }
    
}