<?php

namespace SpotifyAPI;

class Response
{
    protected $data = null;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function lookup($extras = '')
    {
        if (isset($this->data['href'])) {
            $spotify = new SpotifyAPI();
            return $spotify->lookup($this->data['href'], $extras);
        }
        throw new \Exception('This key does not have an href');
    }

    public function __get($key)
    {
        if (is_array($this->data[$key])) {
            if (key($this->data[$key]) === 0) {
                $responses = array();
                foreach ($this->data[$key] as $data) {
                    $responses[] = new Response($data);
                }
                return $responses;
            } else {
                return new Response($this->data[$key]);
            }
        } else {
            return $this->data[$key];
        }
    }

    public function __toString()
    {
        if (isset($this->data['name']) && is_string($this->data['name'])) {
            return $this->data['name'];
        } else {
            throw new \Exception('No name found');
        }
    }
}
