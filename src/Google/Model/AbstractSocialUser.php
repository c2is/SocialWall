<?php

namespace C2iS\SocialWall\Google\Model;

use C2iS\SocialWall\Model\SocialUserInterface;

abstract class AbstractSocialUser implements SocialUserInterface
{
    /** @var string @Serializer\Type("string") */
    protected $id;

    /** @var string @Serializer\Type("string") */
    protected $name;

    /** @var string @Serializer\Type("string") */
    protected $url;

    /** @var string @Serializer\Type("string") */
    protected $image;

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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     *
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;

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
