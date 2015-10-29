<?php

namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CRUDController extends Controller
{

    public function playAction(){
        $object = $this->admin->getSubject();

        die(var_dump($object));


        return new RedirectResponse($this->admin->generateUrl('playlist', ["playlist" => $object->id()]));
    }
}
