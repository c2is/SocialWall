<?php

namespace C2iS\SocialWall\Twitter\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Media
 *
 * @package C2iS\SocialWall\Twitter\Model
 */
class Media
{
    const TYPE_PHOTO = 'photo';

    /** @var string @Serializer\Type("string") */
    protected $id;

    /** @var string @Serializer\Type("string") */
    protected $mediaUrl;

    /** @var string @Serializer\Type("string") */
    protected $mediaSecureUrl;

    /** @var string @Serializer\Type("string") */
    protected $url;

    /** @var string @Serializer\Type("string") */
    protected $displayUrl;

    /** @var string @Serializer\Type("string") */
    protected $type;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $mediaUrl
     *
     * @return $this
     */
    public function setMediaUrl($mediaUrl)
    {
        $this->mediaUrl = $mediaUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->mediaUrl;
    }

    /**
     * @param string $mediaSecureUrl
     *
     * @return $this
     */
    public function setMediaSecureUrl($mediaSecureUrl)
    {
        $this->mediaSecureUrl = $mediaSecureUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getMediaSecureUrl()
    {
        return $this->mediaSecureUrl;
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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $displayUrl
     *
     * @return $this
     */
    public function setDisplayUrl($displayUrl)
    {
        $this->displayUrl = $displayUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayUrl()
    {
        return $this->displayUrl;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
