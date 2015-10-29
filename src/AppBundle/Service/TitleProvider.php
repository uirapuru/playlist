<?php
namespace AppBundle\Service;


use AppBundle\Entity\Song;
use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;

class TitleProvider
{

    /**
     * @var Client
     */
    private $client;

    /**
     * TitleProvider constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getTitle(Song $song){
        $videoId = $song->videoId();
        $url = 'http://youtube.com/get_video_info?video_id='. $videoId;
        /** @var Response $response */
        $response = $this->client->get($url)->send();
        $body = $response->getBody(true);
        parse_str($body, $arr);

        return $arr["title"];
    }
}