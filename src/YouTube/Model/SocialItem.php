<?php

namespace C2iS\SocialWall\YouTube\Model;

use C2iS\SocialWall\Model\AbstractSocialItem;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class SocialItem
 *
 * @package C2iS\SocialWall\YouTube\Model
 */
class SocialItem extends AbstractSocialItem
{
    /** @var SocialUser @Serializer\Type("C2iS\SocialWall\YouTube\Model\SocialUser") */
    protected $user;

    /** @var string @Serializer\Type("string") */
    protected $id;

    /** @var \DateTime @Serializer\Type("DateTime") */
    protected $publishedAt;

    /** @var string @Serializer\Type("string") */
    protected $title;

    /** @var string @Serializer\Type("string") */
    protected $url;

    /** @var string @Serializer\Type("string") */
    protected $content;

    /** @var string @Serializer\Type("string") */
    protected $videoId;

    /** @var string @Serializer\Type("string") */
    protected $views;

    /** @var string @Serializer\Type("string") */
    protected $likes;

    /** @var string @Serializer\Type("string") */
    protected $dislikes;

    /** @var string @Serializer\Type("string") */
    protected $comments;

    /** @var string @Serializer\Type("string") */
    protected $favorites;

    /** @var ThumbnailCollection @Serializer\Type("C2iS\SocialWall\YouTube\Model\ThumbnailCollection") */
    protected $thumbnails;

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
     * @return ThumbnailCollection
     */
    public function getThumbnails()
    {
        return $this->thumbnails;
    }

    /**
     * @param ThumbnailCollection $thumbnails
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
        return $this->thumbnails ? $this->thumbnails->getMedium()->getUrl() : null;
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
