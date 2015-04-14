<?php

namespace C2iS\SocialWall\GooglePlus;

use C2iS\SocialWall\AbstractSocialNetwork;
use C2iS\SocialWall\GooglePlus\Model\Attachment;
use C2iS\SocialWall\GooglePlus\Model\Location;
use C2iS\SocialWall\GooglePlus\Model\SocialItem;
use C2iS\SocialWall\GooglePlus\Model\SocialUser;
use C2iS\SocialWall\Model\SocialItemResult;

/**
 * Class GooglePlusManager
 *
 * @package C2iS\SocialWall\GooglePlus
 */
class GooglePlusManager extends AbstractSocialNetwork
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
        $service = new \Google_Service_Plus($this->client);
        $results = $service->activities->listActivities(sprintf('+%s', $params['user_id']), 'public', $queryParams);

        $socialItems = array();

        /** @var \Google_Service_Plus_Activity $item */
        foreach ($results->getItems() as $item) {
            $socialItems[] = $this->createSocialItem($item);
        }

        $result = new SocialItemResult($socialItems);
        $result->setNextPage($results->getNextPageToken());

        return $result;
    }

    /**
     * @param \Google_Service_Plus_Activity $source
     *
     * @return \C2iS\SocialWall\GooglePlus\Model\SocialItem
     */
    protected function createSocialItem($source)
    {
        $item = new SocialItem();

        $item->setId($source->getId());
        $item->setTitle($source->getTitle());
        $item->setUrl($source->getUrl());
        $item->setPublishedAt(new \DateTime($source->getPublished()));
        $item->setUser($this->createSocialUser($source->getActor()));

        if ($source->getLocation()) {
            $item->setLocation($this->createLocation($source->getLocation()));
        }

        /** @var \Google_Service_Plus_ActivityObject $activityObject */
        $activityObject = $source->getObject();

        $item->setContent($activityObject->getContent());
        $item->setPlusOners($activityObject->getPlusoners()->getTotalItems());
        $item->setResharers($activityObject->getResharers()->getTotalItems());
        $item->setReplies($activityObject->getReplies()->getTotalItems());

        /** @var \Google_Service_Plus_ActivityObjectAttachments $attachment */
        foreach ($activityObject->getAttachments() as $attachment) {
            $item->addAttachment($this->createAttachment($attachment));
        }

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
     * @param \Google_Service_Plus_ActivityObjectAttachments $source
     *
     * @return \C2iS\SocialWall\GooglePlus\Model\Attachment
     */
    protected function createAttachment($source)
    {
        $attachment = new Attachment();

        $attachment->setId($source->getId());
        $attachment->setDisplayName($source->getDisplayName());
        $attachment->setContent($source->getContent());
        $attachment->setUrl($source->getUrl());

        /** @var \Google_Service_Plus_ActivityObjectAttachmentsImage $image */
        if ($image = $source->getImage()) {
            $attachment->setImage($image->getUrl());
        }

        return $attachment;
    }

    /**
     * @param \Google_Service_Plus_Place $source
     *
     * @return \C2iS\SocialWall\GooglePlus\Model\Location
     */
    protected function createLocation($source)
    {
        $location = new Location();

        $location->setId($source->getId());
        $location->setDisplayName($source->getDisplayName());
        $location->setAddress($source->getAddress()->getFormatted());
        $location->setLatitude($source->getPosition()->getLatitude());
        $location->setLongitude($source->getPosition()->getLongitude());

        return $location;
    }

    /**
     * @return array
     */
    public function getQueryParams()
    {
        return array(
            'limit' => 'maxResults',
            'lang' => 'language'
        );
    }

    /**
     * @return array
     */
    public function getRequiredParams()
    {
        return array('user_id');
    }
}
