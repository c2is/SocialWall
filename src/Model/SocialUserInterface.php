<?php

namespace C2iS\SocialWall\Model;

interface SocialUserInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getLocation();

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return string
     */
    public function getFollowers();

    /**
     * @return string
     */
    public function getLocale();
}
