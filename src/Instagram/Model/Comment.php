<?php

namespace C2iS\SocialWall\Instagram\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Comment
 *
 * @package C2iS\SocialWall\Instagram\Model
 */
class Comment
{
    /** @var string @Serializer\Type("string") */
    protected $id;

    /** @var \DateTime @Serializer\Type("DateTime") */
    protected $createdAt;

    /** @var string @Serializer\Type("string") */
    protected $message;

    /** @var SocialUser @Serializer\Type("C2iS\SocialWall\Instagram\Model\SocialUser") */
    protected $user;

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
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

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
}
