<?php

namespace C2iS\SocialWall\Cache;

use C2iS\Component\Json\JsonExtractor;
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
     * @param array  $params
     *
     * @return boolean
     */
    public function isCacheFresh($network, $call, array $params = array())
    {
        $file = $this->getFile($network, $call, $params);

        return file_exists($file) && filesize($file) && filemtime($file) + $this->duration > time();
    }

    /**
     * @param string $network
     * @param string $call
     * @param array  $params
     *
     * @return mixed
     */
    public function getCache($network, $call, array $params = array())
    {
        $result = null;

        if (file_exists($file = $this->getFile($network, $call, $params))) {
            $result = $content = file_get_contents($file);

            if ($this->isJson($content)) {
                JsonExtractor::extract($content, sprintf('$.items[%s:]', $params['limit']));
                $serializer = $this->getSerializer();
                $result     = $serializer->deserialize(
                    $content,
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
     * @param array  $params
     *
     * @return boolean
     */
    public function setCache($network, $call, $result, array $params = array())
    {
        if (
            (is_string($result) && strlen($result) === 0) ||
            ($result instanceof SocialItemResult && !count($result->getItems())) ||
            (!is_string($result) && !$result instanceof SocialItemResult)
        ) {
            return;
        }

        $file    = $this->getFile($network, $call, $params);
        $dirName = dirname($file);

        if (file_exists($dirName) && is_file($dirName)) {
            unlink($dirName);
        }

        if (!file_exists($dirName)) {
            mkdir('/'.$this->getAbsolutePath($dirName), 0777, true);
        }

        if (!file_exists($file)) {
            touch($file);
        }

        $content = $result;

        if (is_object($result)) {
            $serializer = $this->getSerializer();
            $content    = $serializer->serialize($result, 'json');
        }

        file_put_contents($file, $content);
    }

    /**
     * @param string $network
     * @param string $call
     * @param array  $params
     *
     * @return string
     */
    protected function getFile($network, $call, array $params)
    {
        return implode('/', array(rtrim($this->path, '/'), $network, $call, $this->getHashFromParams($params)));
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

    /**
     * @param array $params
     *
     * @return string
     */
    protected function getHashFromParams(array $params)
    {
        unset($params['limit']);
        array_multisort($params);

        return md5(serialize($params));
    }
}
