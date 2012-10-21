<?php

use MyMusic\Model;

include __DIR__ . '/../application.php';

$trackUris = explode("\n", file_get_contents(__DIR__ . '/spotify-ralph-starred-tracks.txt'));

if (!file_exists(__DIR__ . '/spot-resolved-playlist.pson')) {
    foreach ($trackUris as $trackUri) {

        $spotifyApi = new \SpotifyAPI\SpotifyAPI();
        $response = $spotifyApi->lookup($trackUri);

        $track = new Model\Track;
        $track->setTitle($response->name);
        $track->setLength($response->length);
        $track->setNumber($response->{'track-number'});

        $artistsData = $response->artists;

        $artist = new Model\Artist;
        $artist->setName($artistsData[0]->name);
        $track->setArtist($artist);

        $album = new Model\Album;
        $album->setTitle($response->album->name);
        $album->setReleaseDate($response->album->lookup()->released);
        $track->setAlbum($album);

        $tracks[] = $track;
        usleep(100000);
        echo 'Moving on to next track.' . PHP_EOL;
    }
    file_put_contents(__DIR__ . '/spot-resolved-playlist.pson', serialize($tracks));
} else {
    $tracks = unserialize(file_get_contents(__DIR__ . '/spot-resolved-playlist.pson'));
}

var_dump($tracks);


