<?php

namespace C2iS\SocialWall\Instagram\Model;

use C2iS\SocialWall\Model\SocialUserInterface;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class SocialUser
 *
 * @package C2iS\SocialWall\Instagram\Model
 */
class SocialUser implements SocialUserInterface
{
    /** @var string @Serializer\Type("string") */
    protected $id;

    /** @var string @Serializer\Type("string") */
    protected $name;

    /** @var string @Serializer\Type("string") */
    protected $fullName;

    /** @var string @Serializer\Type("string") */
    protected $picture;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
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
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     *
     * @return $this
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     *
     * @return $this
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

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
