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
     * @param array  $params
     *
     * @return boolean
     */
    public function isCacheFresh($network, $call, array $params = array());

    /**
     * @param string $network
     * @param string $call
     * @param array  $params
     *
     * @return mixed
     */
    public function getCache($network, $call, array $params = array());

    /**
     * @param string $network
     * @param string $call
     * @param mixed  $result
     * @param array  $params
     *
     * @return bool
     */
    public function setCache($network, $call, $result, array $params = array());
}
