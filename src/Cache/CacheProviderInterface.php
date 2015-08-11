<?php

namespace C2iS\SocialWall\Cache;

/**
 * Interface CacheProviderInterface
 *
 * @package C2iS\SocialWall\Cache
 */
interface CacheProviderInterface
{
    /**
     * @param string $network
     * @param string $call
     *
     * @return boolean
     */
    public function isCacheFresh($network, $call);

    /**
     * @param string $network
     * @param string $call
     *
     * @return mixed
     */
    public function getCache($network, $call);

    /**
     * @param string $network
     * @param string $call
     * @param mixed  $result
     *
     * @return boolean
     */
    public function setCache($network, $call, $result);
}
