<?php

namespace C2iS\SocialWall\Cache;

use C2iS\SocialWall\Model\SocialItemResult;

/**
 * Interface CacheProviderInterface
 *
 * @package C2iS\SocialWall\Cache
 */
interface CacheProviderInterface
{
    /**
     * @param string $network
     *
     * @return boolean
     */
    public function isCacheFresh($network);

    /**
     * @param string $network
     *
     * @return SocialItemResult
     */
    public function getCache($network);

    /**
     * @param string $network
     * @param SocialItemResult $result
     *
     * @return boolean
     */
    public function setCache($network, SocialItemResult $result);
}
