<?php

namespace C2iS\SocialWall\Flickr\Model;

use C2iS\SocialWall\Model\SocialItemInterface;

/**
 * Class SocialItem
 *
 * @package C2iS\SocialWall\Flickr\Model
 */
class SocialItem implements SocialItemInterface
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $url;

    /** @var string */
    protected $link;

    /** @var string */
    protected $userId;

    /** @var string */
    protected $title;

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
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return $this
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     *
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getSocialNetwork()
    {
        return 'flickr';
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getMessageHtml()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->url;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime()
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

    /**
     * @return \C2iS\SocialWall\Model\SocialUserInterface
     */
    public function getUser()
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

}
