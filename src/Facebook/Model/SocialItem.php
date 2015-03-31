<?php

namespace C2iS\SocialWall\Facebook\Model;

use C2iS\SocialWall\Model\SocialItemInterface;

class SocialItem implements SocialItemInterface
{
    const TYPE_PHOTO = 'photo';
    const TYPE_VIDEO = 'video';
    const TYPE_LINK = 'link';
    const TYPE_STATUS = 'status';

    /** @var string */
    protected $id;

    /** @var string */
    protected $objectId;

    /** @var string */
    protected $name;

    /** @var string */
    protected $message;

    /** @var string */
    protected $image;

    /** @var string */
    protected $link;

    /** @var string */
    protected $icon;

    /** @var string */
    protected $privacy;

    /** @var string */
    protected $type;

    /** @var string */
    protected $statusType;

    /** @var string */
    protected $createdAt;

    /** @var string */
    protected $updatedAt;

    /** @var string */
    protected $shares;

    /** @var array<Like> */
    protected $likes;

    /** @var array<Comment> */
    protected $comments;

    /** @var SocialUser */
    protected $user;

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
     * @param string $objectId
     *
     * @return $this
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;

        return $this;
    }

    /**
     * @return string
     */
    public function getObjectId()
    {
        return $this->objectId;
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
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
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
    public function getImage()
    {
        return $this->image;
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
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $icon
     *
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $privacy
     *
     * @return $this
     */
    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrivacy()
    {
        return $this->privacy;
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

    /**
     * @param string $statusType
     *
     * @return $this
     */
    public function setStatusType($statusType)
    {
        $this->statusType = $statusType;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatusType()
    {
        return $this->statusType;
    }

    /**
     * @param string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $shares
     *
     * @return $this
     */
    public function setShares($shares)
    {
        $this->shares = $shares;

        return $this;
    }

    /**
     * @return string
     */
    public function getShares()
    {
        return $this->shares;
    }

    /**
     * @param array $likes
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
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param array $comments
     *
     * @return $this
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

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
     * @return array
     */
    public function getLikers()
    {
        $likers = array();

        /** @var Like $like */
        foreach ($this->likes as $like) {
            $liker = new SocialUser();
            $liker->setId($like->getId());
            $liker->setName($like->getName());

            $likers[] = $liker;
        }

        return $likers;
    }

    /**
     * @return string
     */
    public function getSocialNetwork()
    {
        return 'facebook';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getMessageHtml()
    {
        return $this->message;
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
