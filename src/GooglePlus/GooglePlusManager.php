<?php

namespace C2iS\SocialWall\GooglePlus;

use C2iS\SocialWall\AbstractSocialNetwork;
use C2iS\SocialWall\GooglePlus\Model\Attachment;
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
        $item->setPublishedAt($source->getPublished());
        $item->setLocation($source->getLocation());
        $item->setUser($this->createSocialUser($source->getActor()));

        /** @var \Google_Service_Plus_ActivityObject $activityObject */
        $activityObject = $source->getObject();

        $item->setContent($activityObject->getContent());
        $item->setPlusOners($activityObject->getPlusoners());
        $item->setResharers($activityObject->getResharers());
        $item->setReplies($activityObject->getReplies());

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
     * @return array
     */
    public function getQueryParams()
    {
        return array(
            'limit' => 'maxResults',
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
