<?php

namespace C2iS\SocialWall\Twitter\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Url
 *
 * @package C2iS\SocialWall\Twitter\Model
 */
class Url
{
    /** @var string @Serializer\Type("string") */
    protected $url;

    /** @var string @Serializer\Type("string") */
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
