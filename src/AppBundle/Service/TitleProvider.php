<?php
namespace AppBundle\Service;

use AppBundle\Entity\Song;
use Goutte\Client;

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
        try {
            $arr = $this->getInfo($song);
        } catch(\Exception $e) {
            if($e->getCode() === 697) {
                $arr = $this->scrap($song);
            }
        }

        return $arr["title"];
    }

    public function getThumb(Song $song){
        try {
            $arr = $this->getInfo($song);
        } catch(\Exception $e) {
            if($e->getCode() === 697) {
                $arr = $this->scrap($song);
            }
        }

        return $arr["thumbnail_url"];
    }

    /**
     * @param Song $song
     * @return array
     */
    private function getInfo(Song $song)
    {
        $videoId = $song->videoId();
        $url = 'http://youtube.com/get_video_info?video_id='. $videoId;
        /** @var Response $response */
        $response = $this->client->getClient()->get($url);
        $body = $response->getBody(true);
        parse_str($body, $arr);

        if(array_key_exists("status", $arr) && $arr["status"] == 'fail')
        {
            throw new \Exception($arr["reason"], 697);
        }

        return $arr;
    }

    private function scrap(Song $song)
    {
        $arr = [];
        $crawler = $this->client->request('GET', $song->url());

        $arr["title"] = $crawler->filter("title")->text();
        $arr["thumbnail_url"] = sprintf('http://img.youtube.com/vi/%s/1.jpg', $song->videoId());

        return $arr;
    }
}