<?php

namespace C2iS\SocialWall\Twitter\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class UserMention
 *
 * @package C2iS\SocialWall\Twitter\Model
 */
class UserMention
{
    /** @var string @Serializer\Type("string") */
    protected $screenName;

    /** @var string @Serializer\Type("string") */
    protected $name;

    /** @var string @Serializer\Type("string") */
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
