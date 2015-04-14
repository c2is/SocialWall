<?php

namespace C2iS\SocialWall\Facebook\Model;

use C2iS\SocialWall\Model\AbstractSocialItem;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class SocialItem
 *
 * @package C2iS\SocialWall\Facebook\Model
 */
class SocialItem extends AbstractSocialItem
{
    const TYPE_PHOTO = 'photo';
    const TYPE_VIDEO = 'video';
    const TYPE_LINK = 'link';
    const TYPE_STATUS = 'status';

    /** @var string @Serializer\Type("string") */
    protected $id;

    /** @var string @Serializer\Type("string") */
    protected $objectId;

    /** @var string @Serializer\Type("string") */
    protected $name;

    /** @var string @Serializer\Type("string") */
    protected $message;

    /** @var array<Attachment> @Serializer\Type("array<C2iS\SocialWall\Facebook\Model\Attachment>") */
    protected $attachments;

    /** @var string @Serializer\Type("string") */
    protected $link;

    /** @var string @Serializer\Type("string") */
    protected $icon;

    /** @var string @Serializer\Type("string") */
    protected $privacy;

    /** @var string @Serializer\Type("string") */
    protected $type;

    /** @var string @Serializer\Type("string") */
    protected $statusType;

    /** @var \DateTime @Serializer\Type("DateTime") */
    protected $createdAt;

    /** @var \DateTime @Serializer\Type("DateTime") */
    protected $updatedAt;

    /** @var string @Serializer\Type("string") */
    protected $shares;

    /** @var array<Like> @Serializer\Type("array<C2iS\SocialWall\Facebook\Model\Like>") */
    protected $likes;

    /** @var array<Comment> @Serializer\Type("array<C2iS\SocialWall\Facebook\Model\Comment>") */
    protected $comments;

    /** @var SocialUser @Serializer\Type("C2iS\SocialWall\Facebook\Model\SocialUser") */
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
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param Attachment $attachment
     *
     * @return $this
     */
    public function addAttachment($attachment)
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * @param array $attachments
     *
     * @return $this
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        /** @var Attachment $attachment */
        $attachment = reset($this->attachments);

        return $attachment ? $attachment->getImage() : null;
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
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

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
     * @param \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return \DateTime
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
