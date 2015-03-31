<?php

namespace C2iS\SocialWall\Flickr;

use C2iS\SocialWall\AbstractSocialNetwork;
use C2iS\SocialWall\Flickr\Model\SocialItem;
use C2iS\SocialWall\Model\SocialItemResult;

class FlickrManager extends AbstractSocialNetwork
{
    /** @var string */
    protected $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return SocialItemResult
     */
    public function getResult(array $params = array(), array $queryParams = array())
    {
        $queryParams = http_build_query(
            array_merge(
                array(
                    'api_key' => $this->apiKey,
                ),
                $queryParams
            )
        );

        $url = sprintf('https://api.flickr.com/services/rest/?%s', $queryParams);
        $rsp = unserialize(file_get_contents($url));

        $results     = $rsp['photos']['photo'];
        $socialItems = array();

        foreach ($results as $item) {
            $socialItems[] = $this->createSocialItem($item);
        }

        $result = new SocialItemResult($socialItems);
        $result->setTotalItems($rsp['photos']['total']);
        $result->setPreviousPage($rsp['photos']['page'] - 1);
        $result->setNextPage($rsp['photos']['page'] + 1);

        return $result;
    }

    /**
     * @param array $source
     *
     * @return \C2iS\SocialWall\Flickr\Model\SocialItem
     */
    protected function createSocialItem(array $source)
    {
        $item = new SocialItem();

        $item->setId($source['id']);
        $item->setTitle($source['title']);
        $item->setUserId($source['owner']);
        $item->setUrl($this->buildUrlFromPhoto($source));
        $item->setLink($this->buildLinkFromPhoto($source));

        return $item;
    }

    /**
     * @param array $photo
     *
     * @return string
     */
    protected function buildUrlFromPhoto($photo)
    {
        return sprintf(
            'http://farm%s.static.flickr.com/%s/%s_%s_m.jpg',
            $photo['farm'],
            $photo['server'],
            $photo['id'],
            $photo['secret']
        );
    }

    /**
     * @param array $photo
     *
     * @return string
     */
    protected function buildLinkFromPhoto($photo)
    {
        return sprintf(
            'https://www.flickr.com/photos/%s/%s',
            $photo['owner'],
            $photo['id']
        );
    }

    /**
     * @return array
     */
    public function getQueryParams()
    {
        return array(
            'limit' => 'per_page',
            'tags',
            'method',
            'format',
            'privacy_filter',
        );
    }

    /**
     * @return array
     */
    public function getRequiredParams()
    {
        return array(
            'method'         => 'flickr.photos.search',
            'format'         => 'php_serial',
            'privacy_filter' => 1,
            'tags',
        );
    }
}
