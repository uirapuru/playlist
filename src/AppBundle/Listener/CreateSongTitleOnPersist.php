<?php
namespace AppBundle\Listener;

use AppBundle\Entity\Song;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class CreateSongTitleOnPersist
 * @package AppBundle\Listener
 */
class CreateSongTitleOnPersist
{
    private $titleProvider;

    /**
     * CreateSongTitleOnPersist constructor.
     * @param $client
     */
    public function __construct($titleProvider)
    {
        $this->titleProvider = $titleProvider;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args){
        $this->setTitle($args);
    }
    
    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args){
        $this->setTitle($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    private function setTitle(LifecycleEventArgs $args) {
        $entity = $args->getEntity();

        if($entity instanceof Song) {
            $title = $this->titleProvider->getTitle($entity);
            $entity->setTitle($title);
        }
    }
}