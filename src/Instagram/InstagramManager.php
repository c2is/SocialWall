<?php

namespace C2iS\SocialWall\Instagram;

use C2iS\SocialWall\AbstractSocialNetwork;
use C2iS\SocialWall\Instagram\Model\Comment;
use C2iS\SocialWall\Instagram\Model\Like;
use C2iS\SocialWall\Instagram\Model\Media;
use C2iS\SocialWall\Instagram\Model\SocialItem;
use C2iS\SocialWall\Instagram\Model\SocialUser;
use C2iS\SocialWall\Model\SocialItemResult;

class InstagramManager extends AbstractSocialNetwork
{
    /** @var string */
    protected $clientId;

    /**
     * @param $clientId
     */
    public function __construct($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return SocialItemResult
     */
    protected function retrieveItemsForUser(array $params = array(), array $queryParams = array())
    {
        $queryParams['client_id'] = $this->clientId;
        set_error_handler(
            function () { /* ignore warning errors from file_get_contents*/
            },
            E_WARNING
        );
        $content = file_get_contents(
            sprintf(
                'https://api.instagram.com/v1/users/%s/media/recent?%s',
                $params['user_id'],
                http_build_query($queryParams)
            )
        );
        restore_error_handler();
        $results = $response = $socialItems = array();

        if ($content) {
            $response = json_decode($content);
            $results  = $response->data;
        }

        foreach ($results as $item) {
            $socialItems[] = $this->createSocialItem($item);
        }

        $result = new SocialItemResult($socialItems);
        $result->setPreviousPage(
            isset($response->pagination->previous_url) ? $response->pagination->previous_url : null
        );
        $result->setNextPage(isset($response->pagination->next_url) ? $response->pagination->next_url : null);

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
        $queryParams['client_id'] = $this->clientId;
        set_error_handler(
            function () { /* ignore warning errors from file_get_contents*/
            },
            E_WARNING
        );
        $content = file_get_contents(
            sprintf(
                'https://api.instagram.com/v1/tags/%s/media/recent?%s',
                $params['tag'],
                http_build_query($queryParams)
            )
        );
        restore_error_handler();
        $results = $response = $socialItems = array();

        if ($content) {
            $response = json_decode($content);
            $results  = $response->data;
        }

        foreach ($results as $item) {
            $socialItems[] = $this->createSocialItem($item);
        }

        $result = new SocialItemResult($socialItems);
        $result->setPreviousPage(
            isset($response->pagination->previous_url) ? $response->pagination->previous_url : null
        );
        $result->setNextPage(isset($response->pagination->next_url) ? $response->pagination->next_url : null);

        return $result;
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return \C2iS\SocialWall\Model\SocialItemResult
     */
    protected function retrieveItemsForLocation(array $params = array(), array $queryParams = array())
    {
        $queryParams['client_id'] = $this->clientId;
        $content                  = $this->getFileContent(
            sprintf(
                'https://api.instagram.com/v1/media/search?%s',
                http_build_query($queryParams)
            )
        );
        $results                  = $response = $socialItems = array();

        if ($content) {
            $response = json_decode($content);
            $results  = $response->data;
        }

        foreach ($results as $item) {
            $socialItems[] = $this->createSocialItem($item);
        }

        $result = new SocialItemResult($socialItems);
        $result->setPreviousPage(
            isset($response->pagination->previous_url) ? $response->pagination->previous_url : null
        );
        $result->setNextPage(isset($response->pagination->next_url) ? $response->pagination->next_url : null);

        return $result;
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return \C2iS\SocialWall\Model\SocialItemResult
     */
    protected function retrieveNumberOfItems(array $params = array(), array $queryParams = array())
    {
        $queryParams = http_build_query(
            array(
                'client_id' => $this->clientId,
            )
        );
        $url         = sprintf('https://api.instagram.com/v1/users/%s?%s', $params['user_id'], $queryParams);
        set_error_handler(
            function () { /* ignore warning errors from file_get_contents*/
            },
            E_WARNING
        );
        $content = file_get_contents($url);
        restore_error_handler();
        $response = json_decode($content);

        return (string)$response->data->counts->media;
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return string
     */
    protected function retrieveNumberOfSubscribers(array $params = array(), array $queryParams = array())
    {
        $queryParams = http_build_query(
            array(
                'client_id' => $this->clientId,
            )
        );
        $url         = sprintf('https://api.instagram.com/v1/users/%s?%s', $params['user_id'], $queryParams);
        set_error_handler(
            function () { /* ignore warning errors from file_get_contents*/
            },
            E_WARNING
        );
        $content = file_get_contents($url);
        restore_error_handler();
        $response = json_decode($content);

        return (string)$response->data->counts->followed_by;
    }

    /**
     * @param object $source
     *
     * @return \C2iS\SocialWall\Instagram\Model\SocialItem
     */
    protected function createSocialItem($source)
    {
        $item = new SocialItem();

        $item->setId($source->id);
        $item->setType($source->type);
        $item->setTitle($source->caption->text);
        $item->setLink($source->link);
        $item->setTags($source->tags);

        $images = array();

        foreach ($source->images as $type => $image) {
            $images[$type] = $this->createMedia($image, $type);
        }

        $item->setImages($images);

        $videos = array();

        foreach ($source->videos as $type => $video) {
            $videos[$type] = $this->createMedia($video, $type);
        }

        $item->setVideos($videos);

        $likes = array();

        foreach ($source->likes->data as $like) {
            $likes[] = $this->createLike($like);
        }

        $item->setLikes($likes);

        $comments = array();

        foreach ($source->comments->data as $comment) {
            $comments[] = $this->createComment($comment);
        }

        if (isset($source->location) && ($location = $source->location)) {
            $item->setLatitude($location->latitude);
            $item->setLongitude($location->longitude);
        }

        $item->setComments($comments);
        $item->setCreatedAt(\DateTime::createFromFormat('U', $source->created_time));
        $item->setUser($this->createSocialUser($source->user));

        return $item;
    }

    /**
     * @param object $source
     * @param string $type
     *
     * @return \C2iS\SocialWall\Instagram\Model\Media
     */
    protected function createMedia($source, $type)
    {
        $media = new Media();

        $media->setType($type);
        $media->setUrl($source->url);
        $media->setWidth($source->width);
        $media->setHeight($source->height);

        return $media;
    }

    /**
     * @param object $source
     *
     * @return \C2iS\SocialWall\Instagram\Model\Like
     */
    protected function createLike($source)
    {
        $like = new Like();

        $like->setUser($this->createSocialUser($source));

        return $like;
    }

    /**
     * @param object $source
     *
     * @return \C2iS\SocialWall\Instagram\Model\Comment
     */
    protected function createComment($source)
    {
        $comment = new Comment();

        $comment->setId($source->id);
        $comment->setCreatedAt(\DateTime::createFromFormat('U', $source->created_time));
        $comment->setMessage($source->text);
        $comment->setUser($this->createSocialUser($source->from));

        return $comment;
    }

    /**
     * @param object $source
     *
     * @return \C2iS\SocialWall\Instagram\Model\SocialUser
     */
    protected function createSocialUser($source)
    {
        $user = new SocialUser();

        $user->setId($source->id);
        $user->setName($source->username);
        $user->setFullName($source->full_name);
        $user->setPicture($source->profile_picture);

        return $user;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    protected function getFileContent($url)
    {
        set_error_handler(
            function ($code, $string) { /* ignore warning errors from file_get_contents */
            },
            E_WARNING
        );
        $content = file_get_contents($url);
        restore_error_handler();

        return $content;
    }

    /**
     * @return array
     */
    public function getQueryParams()
    {
        return array(
            'limit' => 'count',
            'lat',
            'lng',
            'distance',
        );
    }

    /**
     * @return array
     */
    public function getItemsForUserRequiredParams()
    {
        return array(
            'user_id',
        );
    }

    /**
     * @return array
     */
    public function getItemsForTagRequiredParams()
    {
        return array(
            'tag',
        );
    }

    /**
     * @return array
     */
    public function getItemsForLocationRequiredParams()
    {
        return array(
            'lat',
            'lng',
            'distance' => 5000,
        );
    }

    /**
     * @return array
     */
    public function getNumberOfItemsRequiredParams()
    {
        return array(
            'user_id',
        );
    }

    /**
     * @return array
     */
    public function getNumberOfSubscribersRequiredParams()
    {
        return array(
            'user_id',
        );
    }
}
