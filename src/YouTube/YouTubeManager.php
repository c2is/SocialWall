<?php

namespace C2iS\SocialWall\YouTube;

use C2iS\SocialWall\AbstractSocialNetwork;
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
    public function getResult(array $params = array(), array $queryParams = array())
    {
        $service = new \Google_Service_YouTube($this->client);
        $results = $service->playlistItems->listPlaylistItems('id,contentDetails', $queryParams);
        /** @var \Google_Service_YouTube_PageInfo $pageInfo */
        $pageInfo = $results->getPageInfo();
        $videos   = array();
        $nextPage = $results->getNextPageToken();
        $prevPage = $results->getPrevPageToken();

        /** @var \Google_Service_YouTube_PlaylistItem $item */
        foreach ($results as $item) {
            /** @var \Google_Service_YouTube_PlaylistItemContentDetails $contentDetails */
            $contentDetails = $item->getContentDetails();
            $videos[]       = $contentDetails->getVideoId();
        }

        $results = $service->videos->listVideos('id,snippet,statistics', array('id' => implode(',', $videos)));

        $socialItems = array();

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
        );
    }

    /**
     * @return array
     */
    public function getRequiredParams()
    {
        return array('playlistId');
    }
}
