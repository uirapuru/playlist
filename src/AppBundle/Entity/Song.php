<?php
namespace AppBundle\Entity;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class Song
 * @package AppBundle\Entity
 */
class Song
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var Playlist
     */
    private $playlist;

    /**
     * @return string
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return Playlist
     */
    public function playlist()
    {
        return $this->playlist;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $result = parse_url($url);

        if(!strstr($result['host'], "youtube.com")) {
            throw new Exception("Only youtube videos!");
        }

        $this->url = $url;
    }

    /**
     * @param Playlist $playlist
     */
    public function setPlaylist(Playlist $playlist)
    {
        $this->playlist = $playlist;
    }

    /**
     * @return mixed
     */
    public function videoId()
    {
        if(is_null($this->url())) {
            throw new Exception("No url for video!");
        }

        $result = parse_url($this->url());
        parse_str($result["query"], $result);

        return $result["v"];
    }
}