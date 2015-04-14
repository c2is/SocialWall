<?php

namespace C2iS\SocialWall\Cache;

use C2iS\SocialWall\Model\SocialItemResult;
use JMS\Serializer\SerializerBuilder;

class FileCacheProvider implements CacheProviderInterface
{
    /** @var string */
    protected $path;

    /** @var int */
    protected $duration;

    /**
     * @param string $path
     * @param int    $duration
     */
    public function __construct($path, $duration = 3600)
    {
        $this->path     = $path;
        $this->duration = $duration;
    }

    /**
     * @param string $network
     *
     * @return boolean
     */
    public function isCacheFresh($network)
    {
        $file = $this->getFile($network);

        return file_exists($file) && filesize($file = $this->getFile($network)) && filemtime($file) + $this->duration > time();
    }

    /**
     * @param string $network
     *
     * @return SocialItemResult
     */
    public function getCache($network)
    {
        $result = null;

        if (file_exists($file = $this->getFile($network))) {
            $serializer = SerializerBuilder::create()->build();
            $result = $serializer->deserialize(file_get_contents($file), 'C2iS\\SocialWall\\Model\\SocialItemResult', 'json');
        }

        return $result;
    }

    /**
     * @param string           $network
     * @param SocialItemResult $result
     *
     * @return boolean
     */
    public function setCache($network, SocialItemResult $result)
    {
        if (!$result || !count($result->getItems())) {
            return;
        }

        if (!file_exists($file = $this->getFile($network))) {
            touch($file);
        }

        $serializer = SerializerBuilder::create()->build();
        $content = $serializer->serialize($result, 'json');

        file_put_contents($file, $content);
    }

    /**
     * @param string $network
     *
     * @return string
     */
    protected function getFilename($network)
    {
        return $network;
    }

    /**
     * @param string $network
     *
     * @return string
     */
    protected function getFile($network)
    {
        return sprintf('%s/%s', rtrim($this->path, '/'), $this->getFilename($network));
    }
}
