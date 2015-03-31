<?php

namespace C2iS\SocialWall\Twitter\Model;

use C2iS\SocialWall\Model\SocialItemInterface;

/**
 * Class SocialItem
 *
 * @package C2iS\SocialWall\Twitter\Model
 */
class SocialItem implements SocialItemInterface
{
    const REPLY_STATUS = 'status_id';
    const REPLY_USER = 'user_id';
    const REPLY_SCREEN_NAME = 'screen_name';

    /** @var string */
    protected $id;

    /** @var string */
    protected $locale;

    /** @var string */
    protected $resultType;

    /** @var \DateTime */
    protected $createdAt;

    /** @var string */
    protected $text;

    /** @var string */
    protected $source;

    /** @var string */
    protected $truncated;

    /** @var array */
    protected $reply = array(
        self::REPLY_STATUS => null,
        self::REPLY_USER => null,
        self::REPLY_SCREEN_NAME => null,
    );

    /** @var SocialUser */
    protected $user;

    /** @var string */
    protected $geo;

    /** @var string */
    protected $coordinates;

    /** @var string */
    protected $place;

    /** @var string */
    protected $contributors;

    /** @var string */
    protected $retweetCount;

    /** @var string */
    protected $favoriteCount;

    /** @var boolean */
    protected $favorited;

    /** @var boolean */
    protected $retweeted;

    /** @var boolean */
    protected $sensitive;

    /** @var array<UserMention> */
    protected $userMentions = array();

    /** @var array<Media> */
    protected $medias = array();

    /** @var array<Hashtag> */
    protected $hashtags = array();

    /** @var array<Url> */
    protected $urls = array();

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

    /**
     * @param string $resultType
     *
     * @return $this
     */
    public function setResultType($resultType)
    {
        $this->resultType = $resultType;

        return $this;
    }

    /**
     * @return string
     */
    public function getResultType()
    {
        return $this->resultType;
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
     * @param string $text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $source
     *
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $truncated
     *
     * @return $this
     */
    public function setTruncated($truncated)
    {
        $this->truncated = $truncated;

        return $this;
    }

    /**
     * @return string
     */
    public function getTruncated()
    {
        return $this->truncated;
    }

    /**
     * @param array $reply
     *
     * @return $this
     */
    public function setReply($reply)
    {
        $this->reply = $reply;

        return $this;
    }

    /**
     * @return array
     */
    public function getReply()
    {
        return $this->reply;
    }

    /**
     * @param \C2iS\SocialWall\Twitter\Model\SocialUser $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \C2iS\SocialWall\Twitter\Model\SocialUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $geo
     *
     * @return $this
     */
    public function setGeo($geo)
    {
        $this->geo = $geo;

        return $this;
    }

    /**
     * @return string
     */
    public function getGeo()
    {
        return $this->geo;
    }

    /**
     * @param string $coordinates
     *
     * @return $this
     */
    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * @return string
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @param string $place
     *
     * @return $this
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param string $contributors
     *
     * @return $this
     */
    public function setContributors($contributors)
    {
        $this->contributors = $contributors;

        return $this;
    }

    /**
     * @return string
     */
    public function getContributors()
    {
        return $this->contributors;
    }

    /**
     * @param string $retweetCount
     *
     * @return $this
     */
    public function setRetweetCount($retweetCount)
    {
        $this->retweetCount = $retweetCount;

        return $this;
    }

    /**
     * @return string
     */
    public function getRetweetCount()
    {
        return $this->retweetCount;
    }

    /**
     * @param string $favoriteCount
     *
     * @return $this
     */
    public function setFavoriteCount($favoriteCount)
    {
        $this->favoriteCount = $favoriteCount;

        return $this;
    }

    /**
     * @return string
     */
    public function getFavoriteCount()
    {
        return $this->favoriteCount;
    }

    /**
     * @param boolean $retweeted
     *
     * @return $this
     */
    public function setRetweeted($retweeted)
    {
        $this->retweeted = $retweeted;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getRetweeted()
    {
        return $this->retweeted;
    }

    /**
     * @param boolean $favorited
     *
     * @return $this
     */
    public function setFavorited($favorited)
    {
        $this->favorited = $favorited;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getFavorited()
    {
        return $this->favorited;
    }

    /**
     * @param boolean $sensitive
     *
     * @return $this
     */
    public function setSensitive($sensitive)
    {
        $this->sensitive = $sensitive;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getSensitive()
    {
        return $this->sensitive;
    }

    /**
     * @param array $userMentions
     *
     * @return $this
     */
    public function setUserMentions($userMentions)
    {
        $this->userMentions = $userMentions;

        return $this;
    }

    /**
     * @return array
     */
    public function getUserMentions()
    {
        return $this->userMentions;
    }

    /**
     * @param array $medias
     *
     * @return $this
     */
    public function setMedias($medias)
    {
        $this->medias = $medias;

        return $this;
    }

    /**
     * @return array
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * @param array $hashtags
     *
     * @return $this
     */
    public function setHashtags($hashtags)
    {
        $this->hashtags = $hashtags;

        return $this;
    }

    /**
     * @return array
     */
    public function getHashtags()
    {
        return $this->hashtags;
    }

    /**
     * @param array $urls
     *
     * @return $this
     */
    public function setUrls($urls)
    {
        $this->urls = $urls;

        return $this;
    }

    /**
     * @return array
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @return string
     */
    public function getSocialNetwork()
    {
        return 'twitter';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getMessageHtml()
    {
        $message = $this->text;

        /** @var UserMention $userMention */
        foreach ($this->userMentions as $userMention) {
            $message = str_replace(
                sprintf('@%s', $userMention->getScreenName()),
                sprintf(
                    '@<a href="http://www.twitter.com/%s">%s</a>',
                    $userMention->getScreenName(),
                    $userMention->getScreenName()
                ),
                $message
            );
        }

        /** @var Media $media */
        foreach ($this->medias as $media) {
            $message = str_replace(
                $media->getUrl(),
                sprintf('<a href="%s">%s</a>', $media->getUrl(), $media->getUrl()),
                $message
            );
        }

        /** @var Hashtag $hashtag */
        foreach ($this->hashtags as $hashtag) {
            $message = str_replace(
                sprintf('#%s', $hashtag->getText()),
                sprintf(
                    '#<a href="http://www.twitter.com/hashtag/%s">%s</a>',
                    $hashtag->getText(),
                    $hashtag->getText()
                ),
                $message
            );
        }

        /** @var Url $url */
        foreach ($this->urls as $url) {
            $message = str_replace(
                $url->getUrl(),
                sprintf('<a href="%s">%s</a>', $url->getUrl(), $url->getExpandedUrl()),
                $message
            );
        }

        return $message;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        /** @var Media $media */
        foreach ($this->medias as $media) {
            if (Media::TYPE_PHOTO == $media->getType()) {
                return $media->getMediaUrl();
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return sprintf('http://twitter.com/%s/status/%s', $this->user->getScreenName(), $this->getId());
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
    public function getFollowers()
    {
        return $this->favoriteCount;
    }
}
