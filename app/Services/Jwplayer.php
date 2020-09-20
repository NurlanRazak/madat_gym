<?php

namespace App\Services;

class Jwplayer
{

    protected $jwplatform_api;

    public function __construct()
    {
        $this->jwplatform_api = new \Jwplayer\JwplatformAPI('LJvZDNLz', 'q95DJQ5uYoISsl22hw9jG3Tq');
    }

    public function getPlaylists() : array
    {
        return $this->jwplatform_api->call('/channels/list', []);
    }

    public function getPlaylist($channel_key)
    {
        //returns list of videos of playlist
        return $this->jwplatform_api->call('/channels/videos/list', array('channel_key'=>$channel_key));
    }

    public function getVideos()
    {
        return $this->jwplatform_api->call('/videos/list', []);
    }

    public function getVideo($video_key)
    {
        return $this->jwplatform_api->call('/videos/show', array('video_key' => $video_key));
    }
}
