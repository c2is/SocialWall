<?php

namespace C2iS\SocialWall\Twitter\Model;

/**
 * Class Hashtag
 *
 * @package C2iS\SocialWall\Twitter\Model
 */
class Hashtag
{
    /** @var string */
    protected $text;

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
}
