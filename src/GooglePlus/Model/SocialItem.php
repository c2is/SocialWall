<?php

namespace C2iS\SocialWall\GooglePlus\Model;

use C2iS\SocialWall\Model\SocialItemInterface;

/**
 * Class SocialItem
 *
 * @package C2iS\SocialWall\GooglePlus\Model
 */
class SocialItem implements SocialItemInterface
{
    /** @var SocialUser */
    protected $user;

    /** @var string */
    protected $id;

    /** @var \Google_Service_Plus_Place */
    protected $location;

    /** @var \DateTime */
    protected $publishedAt;

    /** @var string */
    protected $title;

    /** @var string */
    protected $url;

    /** @var string */
    protected $content;

    /** @var int */
    protected $plusOners;

    /** @var int */
    protected $replies;

    /** @var int */
    protected $resharers;

    /** @var array<\C2iS\SocialWall\GooglePlus\Model\Attachment> */
    protected $attachments = array();

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
     * @return \Google_Service_Plus_Place
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param \Google_Service_Plus_Place $location
     *
     * @return $this
     */
    public function setLocation($location)
    {
        $this->location = $location;

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
     * @return int
     */
    public function getPlusOners()
    {
        return $this->plusOners;
    }

    /**
     * @param int $plusOners
     *
     * @return $this
     */
    public function setPlusOners($plusOners)
    {
        $this->plusOners = $plusOners;

        return $this;
    }

    /**
     * @return int
     */
    public function getReplies()
    {
        return $this->replies;
    }

    /**
     * @param int $replies
     *
     * @return $this
     */
    public function setReplies($replies)
    {
        $this->replies = $replies;

        return $this;
    }

    /**
     * @return int
     */
    public function getResharers()
    {
        return $this->resharers;
    }

    /**
     * @param int $resharers
     *
     * @return $this
     */
    public function setResharers($resharers)
    {
        $this->resharers = $resharers;

        return $this;
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
    public function getSocialNetwork()
    {
        return 'google_plus';
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
        /** @var Attachment $attachment */
        if ($attachment = reset($this->attachments)) {
            return $attachment->getImage();
        }

        return null;
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
        return $this->plusOners;
    }
}
