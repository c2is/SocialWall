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
     * @param string $call
     *
     * @return boolean
     */
    public function isCacheFresh($network, $call)
    {
        $file = $this->getFile($network, $call);

        return file_exists($file) && filesize($file = $this->getFile($network, $call)) && filemtime(
            $file
        ) + $this->duration > time();
    }

    /**
     * @param string $network
     * @param string $call
     *
     * @return mixed
     */
    public function getCache($network, $call)
    {
        $result = null;

        if (file_exists($file = $this->getFile($network, $call))) {
            $result = file_get_contents($file);

            if ($this->isJson($result)) {
                $serializer = $this->getSerializer();
                $result     = $serializer->deserialize(
                    file_get_contents($file),
                    'C2iS\\SocialWall\\Model\\SocialItemResult',
                    'json'
                );
            }
        }

        return $result;
    }

    /**
     * @param string $network
     * @param string $call
     * @param mixed  $result
     *
     * @return boolean
     */
    public function setCache($network, $call, $result)
    {
        if ((is_string($result) && strlen($result) === 0) || ($result instanceof SocialItemResult && !count(
                    $result->getItems()
                )) || (!is_string($result) && !$result instanceof SocialItemResult)
        ) {
            return;
        }

        $file    = $this->getFile($network, $call);
        $dirName = dirname($file);

        if (!file_exists($dirName)) {
            mkdir('/'.$this->getAbsolutePath($dirName), 0777, true);
        }

        if (!file_exists($file)) {
            touch($file);
        }

        if (is_object($result)) {
            $serializer = $this->getSerializer();
            $result     = $serializer->serialize($result, 'json');
        }

        file_put_contents($file, $result);
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
     * @param string $call
     *
     * @return string
     */
    protected function getFile($network, $call)
    {
        return sprintf('%s/%s/%s', rtrim($this->path, '/'), $this->getFilename($network), $call);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function getAbsolutePath($path)
    {
        $path      = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
        $parts     = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
        $absolutes = array();

        foreach ($parts as $part) {
            if ('.' == $part) {
                continue;
            }
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }

        return implode(DIRECTORY_SEPARATOR, $absolutes);
    }

    /**
     * @param $string
     *
     * @return bool
     */
    protected function isJson($string)
    {
        if (is_numeric($string)) {
            return false;
        }

        json_decode($string);

        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * @return \JMS\Serializer\Serializer
     */
    protected function getSerializer()
    {
        $serializerBuilder = SerializerBuilder::create();
        $serializerBuilder->setCacheDir(sprintf('%s/annotations', $this->path));

        return $serializerBuilder->build();
    }
}
