<?php

namespace C2iS\SocialWall\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Interface AbstractSocialItem
 *
 * @package C2iS\SocialWall\Model
 * @Serializer\Discriminator(field = "socialItemType", map={"facebook": "C2iS\SocialWall\Facebook\Model\SocialItem",
 *                                 "twitter":
 *                                 "C2iS\SocialWall\Twitter\Model\SocialItem", "flick":
 *                                 "C2iS\SocialWall\Flickr\Model\SocialItem", "instagram":
 *                                 "C2iS\SocialWall\Instagram\Model\SocialItem", "youtube":
 *                                 "C2iS\SocialWall\YouTube\Model\SocialItem", "google_plus":
 *                                 "C2iS\SocialWall\GooglePlus\Model\SocialItem"})
 */
abstract class AbstractSocialItem
{
    /** @var string @Serializer\Exclude */
    protected $socialItemType;

    /**
     * @return string
     */
    public function getSocialItemType()
    {
        return $this->socialItemType;
    }

    /**
     * @param string $socialItemType
     *
     * @return $this
     */
    public function setSocialItemType($socialItemType)
    {
        $this->socialItemType = $socialItemType;

        return $this;
    }

    /**
     * @return string
     */
    public abstract function getId();

    /**
     * @return string
     */
    public abstract function getSocialNetwork();

    /**
     * @return string
     */
    public abstract function getTitle();

    /**
     * @return string
     */
    public abstract function getMessage();

    /**
     * @return string
     */
    public abstract function getMessageHtml();

    /**
     * @return string
     */
    public abstract function getImage();

    /**
     * @return string
     */
    public abstract function getLink();

    /**
     * @return \DateTime
     */
    public abstract function getDatetime();

    /**
     * @return string
     */
    public abstract function getLocale();

    /**
     * @return \C2iS\SocialWall\Model\SocialUserInterface
     */
    public abstract function getUser();

    /**
     * @return string
     */
    public abstract function getFollowers();
}
