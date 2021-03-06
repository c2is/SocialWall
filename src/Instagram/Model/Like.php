<?php

namespace C2iS\SocialWall\Instagram\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Like
 *
 * @package C2iS\SocialWall\Instagram\Model
 */
class Like
{
    /** @var SocialUser @Serializer\Type("C2iS\SocialWall\Instagram\Model\SocialUser") */
    protected $user;

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
