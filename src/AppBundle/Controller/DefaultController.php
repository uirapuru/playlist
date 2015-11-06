<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Playlist;
use AppBundle\Entity\Song;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ZMQ;
use ZMQContext;

class DefaultController extends Controller
{
    /**
     * @Template()
     * @Route("/p/{playlist}/s/{song}", name="song", defaults={"playlist" = null, "song" = null})
     * @Route("/p/{playlist}", name="playlist", defaults={"playlist" = null})
     * @Route("/", name="homepage")
     * @ParamConverter("playlist", class="AppBundle:Playlist", isOptional="true")
     * @ParamConverter("song", class="AppBundle:Song", isOptional="true")
     */
    public function indexAction(Request $request, Playlist $playlist = null, Song $song = null)
    {
        $songs = [];

        $videoId = null;
        $nextVideoId = null;
        $nextSong = null;

        $form = $this->createForm("playlist_form", null, [
            "data" => [
                "playlist" => $playlist
            ]
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            return $this->redirectToRoute("playlist", [
                "playlist" => $form->get("playlist")->getData()->id()
            ]);
        }

        if(!is_null($playlist)) {
            /** @var Song[] $songs */
            $songs = $this->getDoctrine()->getRepository("AppBundle:Song")->findByPlaylist($playlist);
        }

        if(count($songs) > 0) {
            foreach($songs as $key => $testSong) {
                if($testSong->id() !== $song->id()) {
                    continue;
                }

                if(array_key_exists($key + 1, $songs)) {
                    $nextSong = $songs[$key + 1];
                    $nextVideoId = $nextSong->id();
                } else {
                    $nextSong = $songs[0];
                    $nextVideoId = $nextSong->id();
                }

                break;
            }
        }

        return [
            "videoId" => $videoId,
            "nextVideoId" => $nextVideoId,
            "song" => $song,
            "nextSong" => $nextSong,
            "songs" => $songs,
            "playlist" => $playlist,
            "playlistForm" => $form->createView()
        ];
    }


    /**
     * @Route("/command/{command}")
     */
    public function sendtestAction($command){
        $context = new ZMQContext();
        $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'my pusher');
        $socket->connect("tcp://localhost:5555");

        $socket->send(json_encode(["command" => $command]));

        return new Response();
    }
}
