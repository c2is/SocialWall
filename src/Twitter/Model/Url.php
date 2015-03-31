<?php

namespace C2iS\SocialWall\Twitter\Model;

/**
 * Class Url
 *
 * @package C2iS\SocialWall\Twitter\Model
 */
class Url
{
    /** @var string */
    protected $url;

    /** @var string */
    protected $expandedUrl;

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
     * @param string $expandedUrl
     *
     * @return $this
     */
    public function setExpandedUrl($expandedUrl)
    {
        $this->expandedUrl = $expandedUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getExpandedUrl()
    {
        return $this->expandedUrl;
    }
}
