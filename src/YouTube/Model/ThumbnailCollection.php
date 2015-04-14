<?php

namespace C2iS\SocialWall\YouTube\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class ThumbnailCollection
 *
 * @package C2iS\SocialWall\YouTube\Model
 */
class ThumbnailCollection
{
    /** @var Thumbnail @Serializer\Type("C2iS\SocialWall\YouTube\Model\Thumbnail") */
    protected $default;

    /** @var Thumbnail @Serializer\Type("C2iS\SocialWall\YouTube\Model\Thumbnail") */
    protected $high;

    /** @var Thumbnail @Serializer\Type("C2iS\SocialWall\YouTube\Model\Thumbnail") */
    protected $maxRes;

    /** @var Thumbnail @Serializer\Type("C2iS\SocialWall\YouTube\Model\Thumbnail") */
    protected $medium;

    /** @var Thumbnail @Serializer\Type("C2iS\SocialWall\YouTube\Model\Thumbnail") */
    protected $standard;

    /**
     * @return Thumbnail
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param Thumbnail $default
     *
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @return Thumbnail
     */
    public function getHigh()
    {
        return $this->high;
    }

    /**
     * @param Thumbnail $high
     *
     * @return $this
     */
    public function setHigh($high)
    {
        $this->high = $high;

        return $this;
    }

    /**
     * @return Thumbnail
     */
    public function getMaxRes()
    {
        return $this->maxRes;
    }

    /**
     * @param Thumbnail $maxRes
     *
     * @return $this
     */
    public function setMaxRes($maxRes)
    {
        $this->maxRes = $maxRes;

        return $this;
    }

    /**
     * @return Thumbnail
     */
    public function getMedium()
    {
        return $this->medium;
    }

    /**
     * @param Thumbnail $medium
     *
     * @return $this
     */
    public function setMedium($medium)
    {
        $this->medium = $medium;

        return $this;
    }

    /**
     * @return Thumbnail
     */
    public function getStandard()
    {
        return $this->standard;
    }

    /**
     * @param Thumbnail $standard
     *
     * @return $this
     */
    public function setStandard($standard)
    {
        $this->standard = $standard;

        return $this;
    }
}
