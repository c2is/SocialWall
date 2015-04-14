<?php

namespace C2iS\SocialWall\Facebook\Model;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class Comment
 *
 * @package C2iS\SocialWall\Facebook\Model
 */
class Comment
{
    /** @var  string @Serializer\Type("string") */
    protected $id;

    /** @var SocialUser @Serializer\Type("C2iS\SocialWall\Facebook\Model\SocialUser") */
    protected $user;

    /** @var  \DateTime @Serializer\Type("DateTime") */
    protected $createdAt;

    /** @var string @Serializer\Type("string") */
    protected $text;

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
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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
