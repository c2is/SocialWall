<?php

namespace C2iS\SocialWall\YouTube\Model;

use C2iS\SocialWall\Model\SocialItemInterface;

/**
 * Class SocialItem
 *
 * @package C2iS\SocialWall\YouTube\Model
 */
class SocialItem implements SocialItemInterface
{
    /** @var SocialUser */
    protected $user;

    /** @var string */
    protected $id;

    /** @var \DateTime */
    protected $publishedAt;

    /** @var string */
    protected $title;

    /** @var string */
    protected $url;

    /** @var string */
    protected $content;

    /** @var string */
    protected $videoId;

    /** @var string */
    protected $views;

    /** @var string */
    protected $likes;

    /** @var string */
    protected $dislikes;

    /** @var string */
    protected $comments;

    /** @var string */
    protected $favorites;

    /** @var \Google_Service_YouTube_ThumbnailDetails */
    protected $thumbnails = array();

    /**
     * @return SocialUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param SocialUser $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

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
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @param \DateTime $publishedAt
     *
     * @return $this
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;

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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * @param string $videoId
     *
     * @return $this
     */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;

        return $this;
    }

    /**
     * @return string
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param string $views
     *
     * @return $this
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * @return string
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param string $likes
     *
     * @return $this
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * @return string
     */
    public function getDislikes()
    {
        return $this->dislikes;
    }

    /**
     * @param string $dislikes
     *
     * @return $this
     */
    public function setDislikes($dislikes)
    {
        $this->dislikes = $dislikes;

        return $this;
    }

    /**
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param string $comments
     *
     * @return $this
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @return string
     */
    public function getFavorites()
    {
        return $this->favorites;
    }

    /**
     * @param string $favorites
     *
     * @return $this
     */
    public function setFavorites($favorites)
    {
        $this->favorites = $favorites;

        return $this;
    }

    /**
     * @return \Google_Service_YouTube_ThumbnailDetails
     */
    public function getThumbnails()
    {
        return $this->thumbnails;
    }

    /**
     * @param \Google_Service_YouTube_ThumbnailDetails $thumbnails
     *
     * @return $this
     */
    public function setThumbnails($thumbnails)
    {
        $this->thumbnails = $thumbnails;

        return $this;
    }

    /**
     * @return string
     */
    public function getSocialNetwork()
    {
        return 'youtube';
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getMessageHtml()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->thumbnails->getMedium()->getUrl();
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->url;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->publishedAt;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getFollowers()
    {
        return $this->views;
    }
}
