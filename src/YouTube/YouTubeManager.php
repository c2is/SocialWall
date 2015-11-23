<?php

namespace C2iS\SocialWall\YouTube;

use C2iS\SocialWall\AbstractSocialNetwork;
use C2iS\SocialWall\Exception\NotImplementedException;
use C2iS\SocialWall\YouTube\Model\SocialItem;
use C2iS\SocialWall\YouTube\Model\SocialUser;
use C2iS\SocialWall\Model\SocialItemResult;
use C2iS\SocialWall\YouTube\Model\Thumbnail;
use C2iS\SocialWall\YouTube\Model\ThumbnailCollection;

/**
 * Class YouTubeManager
 *
 * @package C2iS\SocialWall\YouTube
 */
class YouTubeManager extends AbstractSocialNetwork
{
    /** @var \Google_Client */
    protected $client;

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $applicationName
     */
    public function __construct($clientId, $clientSecret = null, $applicationName = null)
    {
        $client = new \Google_Client();

        // if $clientSecret is null we assume $clientId is a developer key
        if (null === $clientSecret) {
            $client->setDeveloperKey($clientId);
        } else {
            $client->setClientId($clientId);
            $client->setClientSecret($clientSecret);
        }

        if (null !== $applicationName) {
            $client->setApplicationName($applicationName);
        }

        $this->client = $client;
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return SocialItemResult
     */
    protected function retrieveItemsForUser(array $params = array(), array $queryParams = array())
    {
        // Limit for youtube is maximum 50 (webservice limitation)
        $queryParams['maxResults'] = min(50, $queryParams['maxResults']);
        $service                   = new \Google_Service_YouTube($this->client);
        $results                   = $service->search->listSearch('id', $queryParams);

        $socialItems = array();
        $videos      = array();

        /** @var \Google_Service_YouTube_PageInfo $pageInfo */
        $pageInfo = $results->getPageInfo();
        $nextPage = $results->getNextPageToken();
        $prevPage = $results->getPrevPageToken();

        /** @var \Google_Service_YouTube_SearchResult $item */
        foreach ($results as $item) {
            /** @var \Google_Service_YouTube_ResourceId */
            $id = $item->getId();
            $videos[] = $id->getVideoId();
        }

        $results = $service->videos->listVideos('id,snippet,statistics', array('id' => implode(',', $videos)));

        /** @var \Google_Service_YouTube_Video $item */
        foreach ($results->getItems() as $item) {
            $socialItems[] = $this->createSocialItem($item);
        }

        $result = new SocialItemResult($socialItems);
        $result->setNextPage($nextPage);
        $result->setPreviousPage($prevPage);
        $result->setTotalItems($pageInfo->getTotalResults());

        return $result;
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return \C2iS\SocialWall\Model\SocialItemResult
     */
    protected function retrieveItemsForTag(array $params = array(), array $queryParams = array())
    {
        // Limit for youtube is maximum 50 (webservice limitation)
        $queryParams['maxResults'] = min(50, $queryParams['maxResults']);
        $service                   = new \Google_Service_YouTube($this->client);
        $results                   = $service->playlistItems->listPlaylistItems('id,contentDetails', $queryParams);

        $socialItems = array();
        $videos      = array();

        /** @var \Google_Service_YouTube_PageInfo $pageInfo */
        $pageInfo = $results->getPageInfo();
        $nextPage = $results->getNextPageToken();
        $prevPage = $results->getPrevPageToken();

        /** @var \Google_Service_YouTube_PlaylistItem $item */
        foreach ($results as $item) {
            /** @var \Google_Service_YouTube_PlaylistItemContentDetails $contentDetails */
            $contentDetails = $item->getContentDetails();
            $videos[]       = $contentDetails->getVideoId();
        }

        $results = $service->videos->listVideos('id,snippet,statistics', array('id' => implode(',', $videos)));

        /** @var \Google_Service_YouTube_Video $item */
        foreach ($results->getItems() as $item) {
            $socialItems[] = $this->createSocialItem($item);
        }

        $result = new SocialItemResult($socialItems);
        $result->setNextPage($nextPage);
        $result->setPreviousPage($prevPage);
        $result->setTotalItems($pageInfo->getTotalResults());

        return $result;
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return \C2iS\SocialWall\Model\SocialItemResult
     * @throws \C2iS\SocialWall\Exception\NotImplementedException
     */
    protected function retrieveItemsForLocation(array $params = array(), array $queryParams = array())
    {
        throw new NotImplementedException('Not implemented yet');
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return \C2iS\SocialWall\Model\SocialItemResult
     * @throws \C2iS\SocialWall\Exception\NotImplementedException
     */
    protected function retrieveNumberOfItems(array $params = array(), array $queryParams = array())
    {
        throw new NotImplementedException(
            'At this time Youtube API does not provide an efficient way to get this information'
        );
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return string
     */
    public function retrieveNumberOfSubscribers(array $params = array(), array $queryParams = array())
    {
        $service = new \Google_Service_YouTube($this->client);

        return (string)$service->channels->listChannels('id,statistics', array('id' => $queryParams['channelId']))->getItems(
        )[0]->getStatistics()->viewCount;
    }

    /**
     * @param \Google_Service_YouTube_Video $source
     *
     * @return \C2iS\SocialWall\YouTube\Model\SocialItem
     */
    protected function createSocialItem($source)
    {
        $item = new SocialItem();

        /** @var \Google_Service_YouTube_VideoSnippet $snippet */
        $snippet = $source->getSnippet();

        $item->setId($source->getId());
        $item->setTitle($snippet->getTitle());
        $item->setVideoId($source->getId());
        $item->setPublishedAt(new \DateTime($snippet->getPublishedAt()));
        $item->setContent($snippet->getDescription());
        $item->setUrl($this->createUrl($source->getId()));

        /** @var \Google_Service_YouTube_VideoStatistics $statistics */
        $statistics = $source->getStatistics();

        $item->setViews($statistics->getViewCount());
        $item->setLikes($statistics->getLikeCount());
        $item->setDislikes($statistics->getDislikeCount());
        $item->setComments($statistics->getCommentCount());
        $item->setFavorites($statistics->getFavoriteCount());
        $item->setThumbnails($this->createThumbnailCollection($snippet->getThumbnails()));

        return $item;
    }

    /**
     * @param \Google_Service_Plus_ActivityActor $source
     *
     * @return \C2iS\SocialWall\GooglePlus\Model\SocialUser
     */
    protected function createSocialUser($source)
    {
        $user = new SocialUser();

        $user->setId($source->getId());
        $user->setName($source->getName());
        $user->setUrl($source->getUrl());
        $user->setImage($source->getImage() ? $source->getImage()->getUrl() : null);

        return $user;
    }

    /**
     * @param \Google_Service_YouTube_ThumbnailDetails $source
     *
     * @return \C2iS\SocialWall\YouTube\Model\ThumbnailCollection
     */
    protected function createThumbnailCollection($source)
    {
        $thumbnailCollection = new ThumbnailCollection();

        if ($source->getDefault()) {
            $thumbnailCollection->setDefault($this->createThumbnail($source->getDefault()));
        }

        if ($source->getHigh()) {
            $thumbnailCollection->setHigh($this->createThumbnail($source->getHigh()));
        }

        if ($source->getMaxres()) {
            $thumbnailCollection->setMaxRes($this->createThumbnail($source->getMaxres()));
        }

        if ($source->getMedium()) {
            $thumbnailCollection->setMedium($this->createThumbnail($source->getMedium()));
        }

        if ($source->getStandard()) {
            $thumbnailCollection->setStandard($this->createThumbnail($source->getStandard()));
        }

        return $thumbnailCollection;
    }

    /**
     * @param \Google_Service_YouTube_Thumbnail $source
     *
     * @return \C2iS\SocialWall\YouTube\Model\Thumbnail
     */
    protected function createThumbnail($source)
    {
        $thumbnail = new Thumbnail();

        $thumbnail->setUrl($source->getUrl());
        $thumbnail->setWidth($source->getWidth());
        $thumbnail->setHeight($source->getHeight());

        return $thumbnail;
    }

    /**
     * @param string $videoId
     *
     * @return string
     */
    protected function createUrl($videoId)
    {
        return sprintf('http://www.youtube.com/watch?v=%s', $videoId);
    }

    /**
     * @return array
     */
    public function getQueryParams()
    {
        return array(
            'limit' => 'maxResults',
            'playlistId',
            'channelId',
        );
    }

    /**
     * @return array
     */
    public function getItemsForTagRequiredParams()
    {
        return array('playlistId');
    }

    /**
     * @return array
     */
    public function getItemsForUserRequiredParams()
    {
        return array('channelId');
    }

    /**
     * @return array
     */
    public function getNumberOfSubscribersRequiredParams()
    {
        return array('channelId');
    }
}
