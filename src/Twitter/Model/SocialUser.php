<?php

namespace C2iS\SocialWall\Twitter\Model;

use C2iS\SocialWall\Model\SocialUserInterface;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class SocialUser
 *
 * @package C2iS\SocialWall\Twitter\Model
 */
class SocialUser implements SocialUserInterface
{
    /** @var string @Serializer\Type("string") */
    protected $id;

    /** @var string @Serializer\Type("string") */
    protected $name;

    /** @var string @Serializer\Type("string") */
    protected $screenName;

    /** @var string @Serializer\Type("string") */
    protected $location;

    /** @var string @Serializer\Type("string") */
    protected $description;

    /** @var boolean @Serializer\Type("boolean") */
    protected $protected;

    /** @var string @Serializer\Type("string") */
    protected $url;

    /** @var string @Serializer\Type("string") */
    protected $followers;

    /** @var string @Serializer\Type("string") */
    protected $friends;

    /** @var string @Serializer\Type("string") */
    protected $listed;

    /** @var string @Serializer\Type("string") */
    protected $favourites;

    /** @var \DateTime @Serializer\Type("DateTime") */
    protected $createdAt;

    /** @var string @Serializer\Type("string") */
    protected $timezone;

    /** @var boolean @Serializer\Type("boolean") */
    protected $verified;

    /** @var string @Serializer\Type("string") */
    protected $locale;

    /** @var array<UserMention> @Serializer\Type("array<C2iS\SocialWall\Twitter\Model\UserMention>") */
    protected $userMentions = array();

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $screenName
     *
     * @return $this
     */
    public function setScreenName($screenName)
    {
        $this->screenName = $screenName;

        return $this;
    }

    /**
     * @return string
     */
    public function getScreenName()
    {
        return $this->screenName;
    }

    /**
     * @param string $location
     *
     * @return $this
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param boolean $protected
     *
     * @return $this
     */
    public function setProtected($protected)
    {
        $this->protected = $protected;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getProtected()
    {
        return $this->protected;
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
     * @param string $followers
     *
     * @return $this
     */
    public function setFollowers($followers)
    {
        $this->followers = $followers;

        return $this;
    }

    /**
     * @return string
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * @param string $friends
     *
     * @return $this
     */
    public function setFriends($friends)
    {
        $this->friends = $friends;

        return $this;
    }

    /**
     * @return string
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * @param string $listed
     *
     * @return $this
     */
    public function setListed($listed)
    {
        $this->listed = $listed;

        return $this;
    }

    /**
     * @return string
     */
    public function getListed()
    {
        return $this->listed;
    }

    /**
     * @param string $favourites
     *
     * @return $this
     */
    public function setFavourites($favourites)
    {
        $this->favourites = $favourites;

        return $this;
    }

    /**
     * @return string
     */
    public function getFavourites()
    {
        return $this->favourites;
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
     * @param string $timezone
     *
     * @return $this
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param boolean $verified
     *
     * @return $this
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getVerified()
    {
        return $this->verified;
    }

    /**
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
}
