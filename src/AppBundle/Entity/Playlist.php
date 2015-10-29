<?php
namespace AppBundle\Entity;

/**
 * Class Playlist
 * @package AppBundle\Entity
 */
class Playlist
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Song[]
     */
    private $songs;

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return Song[]
     */
    public function songs()
    {
        return $this->songs;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return sprintf("%s (%s)", $this->name(), $this->id());
    }
}