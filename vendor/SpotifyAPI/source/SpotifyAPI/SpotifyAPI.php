<?php

namespace SpotifyAPI;

class SpotifyAPI
{
    public function lookup($uri, $extras = '')
    {
        // set context and get contents
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'header' => "Accept: application/json\r\nContent-type: application/json\r\n",
                'ignore_errors' => true,
                'follow_location' => false
            )
        ));

        $urlPath = 'http://ws.spotify.com/lookup/1/?uri=' . $uri . ($extras ? '&extras=' . $extras : '');

        $fh = fopen($urlPath, 'r', false, $context);
//        $metadata = stream_get_meta_data($fh);
        $content = stream_get_contents($fh);
        fclose($fh);

        $data = json_decode($content, true);
        $data = $data[$data['info']['type']];

        return new Response($data);
    }

    public function search()
    {

    }
}