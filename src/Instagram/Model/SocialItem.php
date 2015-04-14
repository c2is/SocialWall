<?php

namespace C2iS\SocialWall\Instagram\Model;

use C2iS\SocialWall\Model\AbstractSocialItem;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class SocialItem
 *
 * @package C2iS\SocialWall\Instagram\Model
 */
class SocialItem extends AbstractSocialItem
{
    /** @var string @Serializer\Type("string") */
    protected $id;

    /** @var string @Serializer\Type("string") */
    protected $type;

    /** @var string @Serializer\Type("string") */
    protected $title;

    /** @var string @Serializer\Type("string") */
    protected $link;

    /** @var array<string> @Serializer\Type("array<string>") */
    protected $tags;

    /** @var array<string, Image> @Serializer\Type("array<string, C2iS\SocialWall\Instagram\Model\Image>") */
    protected $images;

    /** @var array<Like> @Serializer\Type("array<C2iS\SocialWall\Instagram\Model\Like>") */
    protected $likes;

    /** @var array<Comment> @Serializer\Type("array<C2iS\SocialWall\Instagram\Model\Comment>") */
    protected $comments;

    /** @var \DateTime @Serializer\Type("DateTime") */
    protected $createdAt;

    /** @var SocialUser @Serializer\Type("C2iS\SocialWall\Instagram\Model\SocialUser") */
    protected $user;

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
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
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param $link
     *
     * @return $this
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param $tags
     *
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param $images
     *
     * @return $this
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return array
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param $likes
     *
     * @return $this
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * @return array
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param $comments
     *
     * @return $this
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

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
    public function getSocialNetwork()
    {
        return 'instagram';
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
        return isset($this->images['low_resolution']) ? $this->images['low_resolution']->getUrl() : null;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->createdAt;
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
        return count($this->likes);
    }
}
