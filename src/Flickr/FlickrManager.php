<?php

namespace C2iS\SocialWall\Flickr;

use C2iS\SocialWall\AbstractSocialNetwork;
use C2iS\SocialWall\Exception\NotImplementedException;
use C2iS\SocialWall\Flickr\Model\SocialItem;
use C2iS\SocialWall\Model\SocialItemResult;

/**
 * Class FlickrManager
 *
 * @package C2iS\SocialWall\Flickr
 */
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
    protected function retrieveItemsForUser(array $params = array(), array $queryParams = array())
    {
        $queryParams['api_key'] = $this->apiKey;
        $url                    = sprintf('https://api.flickr.com/services/rest/?%s', http_build_query($queryParams));

        $rsp = unserialize(file_get_contents($url));

        $results     = isset($rsp['photos']['photo']) && $rsp['photos']['photo'] ? $rsp['photos']['photo'] : array();
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
     * @param array $params
     * @param array $queryParams
     *
     * @return SocialItemResult
     */
    protected function retrieveItemsForTag(array $params = array(), array $queryParams = array())
    {
        $queryParams['api_key'] = $this->apiKey;
        $url                    = sprintf('https://api.flickr.com/services/rest/?%s', http_build_query($queryParams));

        $rsp = unserialize(file_get_contents($url));

        $results     = isset($rsp['photos']['photo']) && $rsp['photos']['photo'] ? $rsp['photos']['photo'] : array();
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
     * @param array $params
     * @param array $queryParams
     *
     * @return SocialItemResult
     */
    protected function retrieveNumberOfItems(array $params = array(), array $queryParams = array())
    {
        $queryParams['api_key'] = $this->apiKey;
        $url                    = sprintf('https://api.flickr.com/services/rest/?%s', http_build_query($queryParams));
        $rsp                    = unserialize(file_get_contents($url));

        return (string)$rsp['photos']['total'];
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return string
     * @throws \C2iS\SocialWall\Exception\NotImplementedException
     */
    protected function retrieveNumberOfSubscribers(array $params = array(), array $queryParams = array())
    {
        throw new NotImplementedException('At this time Flickr does not provide a webservice for this information');
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

        if (isset($source['datetaken'])) {
            $item->setDateTaken(\DateTime::createFromFormat('Y-m-d H:i:s', $source['datetaken']));
        }

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
            'extras',
            'user_id',
        );
    }

    /**
     * @return array
     */
    public function getItemsForUserRequiredParams()
    {
        return array(
            'method'         => 'flickr.people.getPublicPhotos',
            'format'         => 'php_serial',
            'privacy_filter' => 1,
            'extras'         => 'date_taken',
            'user_id'
        );
    }

    /**
     * @return array
     */
    public function getItemsForTagRequiredParams()
    {
        return array(
            'method'         => 'flickr.photos.search',
            'format'         => 'php_serial',
            'privacy_filter' => 1,
            'extras'         => 'date_taken',
            'tags',
        );
    }

    /**
     * @return array
     */
    protected function getNumberOfItemsRequiredParams()
    {
        return array(
            'method'         => 'flickr.people.getPublicPhotos',
            'format'         => 'php_serial',
            'privacy_filter' => 1,
            'user_id',
        );
    }
}
