<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Playlist;
use AppBundle\Entity\Song;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="homepage")
     * @Route("/{playlist}", name="playlist", defaults={"playlist" = null})
     * @Route("/{playlist}/{song}", name="song", defaults={"playlist" = null, "song" = null})
     * @ParamConverter("playlist", class="AppBundle:Playlist", isOptional="true")
     * @ParamConverter("song", class="AppBundle:Song", isOptional="true")
     */
    public function indexAction(Request $request, Playlist $playlist = null, Song $song = null)
    {
        $form = $this->createForm("playlist_form");
        $form->handleRequest($request);

        if($playlist = $form->get("playlist")->getData())
        {
            return $this->redirectToRoute("playlist", ["playlist" => $playlist->id()]);
        }

        if(!is_null($playlist)) {
            /** @var Song[] $songs */
            $songs = $this->getDoctrine()->getRepository("AppBundle:Song")->findByPlaylist($playlist);
        } else {
            $songs = [];
        }

        $videoId = null;
        $nextVideoId = null;

        if(count($songs) > 0) {
            foreach($songs as $key => $testSong) {
                if($testSong->id() !== $song->id()) {
                    continue;
                }

                if(array_key_exists($key + 1, $songs)) {
                    $nextVideoId = $songs[$key + 1]->videoId();
                } else {
                    $nextVideoId = $songs[0]->videoId();
                }

                break;
            }
        }

        return [
            "videoId" => $videoId,
            "nextVideoId" => $nextVideoId,
            "songs" => $songs,
            "playlistForm" => $form->createView()
        ];
        return  [];
    }
}
