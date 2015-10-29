<?php
namespace AppBundle\Listener;

use AppBundle\Entity\Song;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class CreateSongTitleOnPersist
 * @package AppBundle\Listener
 */
class CreateSongThumbOnPersist
{
    private $provider;

    /**
     * CreateSongTitleOnPersist constructor.
     * @param $client
     */
    public function __construct($provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args){
        $this->setThumb($args);
    }
    
    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args){
        $this->setThumb($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    private function setThumb(LifecycleEventArgs $args) {
        $entity = $args->getEntity();

        if($entity instanceof Song) {
            $thumb = $this->provider->getThumb($entity);
            $entity->setThumb($thumb);
        }
    }
}