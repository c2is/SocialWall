<?php

namespace C2iS\SocialWall\Twitter\Model;

/**
 * Class UserMention
 *
 * @package C2iS\SocialWall\Twitter\Model
 */
class UserMention
{
    /** @var string */
    protected $screenName;

    /** @var string */
    protected $name;

    /** @var string */
    protected $id;

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
}
