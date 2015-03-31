<?php

namespace C2iS\SocialWall\Model;

interface SocialItemInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getSocialNetwork();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return string
     */
    public function getMessageHtml();

    /**
     * @return string
     */
    public function getImage();

    /**
     * @return string
     */
    public function getLink();

    /**
     * @return \DateTime
     */
    public function getDatetime();

    /**
     * @return string
     */
    public function getLocale();

    /**
     * @return \C2iS\SocialWall\Model\SocialUserInterface
     */
    public function getUser();

    /**
     * @return string
     */
    public function getFollowers();
}
