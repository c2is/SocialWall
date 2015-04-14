<?php

namespace C2iS\SocialWall\Facebook\Model;

use C2iS\SocialWall\Model\SocialUserInterface;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class SocialUser
 *
 * @package C2iS\SocialWall\Facebook\Model
 */
class SocialUser implements SocialUserInterface
{
    /** @var string @Serializer\Type("string") */
    protected $id;

    /** @var string @Serializer\Type("string") */
    protected $name;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getFollowers()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return null;
    }

}
