<?php

namespace App\Services;

class Jwplayer
{

    protected $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function getPlaylists() : array
    {
        return $this->sendRequest("playlists");
    }

    public function getPlaylist($playlist)
    {
        return $this->sendRequest("playlists/{$playlist}");
    }

    public function getVideos($playlist)
    {
        return $this->sendRequest("playlists/{$playlist}");
    }

    public function getVideo($video)
    {
        return $this->sendRequest("video/{$video}");
    }

    protected function sendRequest($url, $method = 'GET')
    {
        $url = "https://cdn.jwplayer.com/v2/{$url}";
        $response = $this->client->request($method, $url);
        return json_decode($response->getBody());
    }
}
