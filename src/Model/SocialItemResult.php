<?php

namespace C2iS\SocialWall\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SocialItemResult
 *
 * @package C2iS\SocialWall\Model
 */
class SocialItemResult
{
    /** @var array<AbstractSocialItem> @Serializer\Type("array<C2iS\SocialWall\Model\AbstractSocialItem>") */
    protected $items = array();

    /** @var string @Serializer\Type("string") */
    protected $totalItems;

    /** @var string @Serializer\Type("string") */
    protected $previousPage;

    /** @var string @Serializer\Type("string") */
    protected $nextPage;

    /**
     * @param array $items
     */
    public function __construct(array $items = array())
    {
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $items
     *
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return string
     */
    public function getTotalItems()
    {
        return $this->totalItems;
    }

    /**
     * @param string $totalItems
     *
     * @return $this
     */
    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;

        return $this;
    }

    /**
     * @return string
     */
    public function getPreviousPage()
    {
        return $this->previousPage;
    }

    /**
     * @param string $previousPage
     *
     * @return $this
     */
    public function setPreviousPage($previousPage)
    {
        $this->previousPage = $previousPage;

        return $this;
    }

    /**
     * @return string
     */
    public function getNextPage()
    {
        return $this->nextPage;
    }

    /**
     * @param string $nextPage
     *
     * @return $this
     */
    public function setNextPage($nextPage)
    {
        $this->nextPage = $nextPage;

        return $this;
    }
}
