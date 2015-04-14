<?php

namespace C2iS\SocialWall\Instagram;

use C2iS\SocialWall\AbstractSocialNetwork;
use C2iS\SocialWall\Instagram\Model\Comment;
use C2iS\SocialWall\Instagram\Model\Image;
use C2iS\SocialWall\Instagram\Model\Like;
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
    public function getResult(array $params = array(), array $queryParams = array())
    {
        $queryParams = http_build_query(
            array_merge(
                array(
                    'client_id' => $this->clientId,
                ),
                $queryParams
            )
        );

        $response = json_decode(
            file_get_contents(
                sprintf('https://api.instagram.com/v1/tags/%s/media/recent?%s', $params['tag'], $queryParams)
            )
        );

        $results     = $response->data;
        $socialItems = array();

        foreach ($results as $item) {
            $socialItems[] = $this->createSocialItem($item);
        }

        $result = new SocialItemResult($socialItems);
        $result->setPreviousPage(isset($response->pagination->previous_url) ? $response->pagination->previous_url : null);
        $result->setNextPage(isset($response->pagination->next_url) ? $response->pagination->next_url : null);

        return $result;
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
            $images[$type] = $this->createImage($image, $type);
        }

        $item->setImages($images);

        $likes = array();

        foreach ($source->likes->data as $like) {
            $likes[] = $this->createLike($like);
        }

        $item->setLikes($likes);

        $comments = array();

        foreach ($source->comments->data as $comment) {
            $comments[] = $this->createComment($comment);
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
     * @return \C2iS\SocialWall\Instagram\Model\Image
     */
    protected function createImage($source, $type)
    {
        $image = new Image();

        $image->setType($type);
        $image->setUrl($source->url);
        $image->setWidth($source->width);
        $image->setHeight($source->height);

        return $image;
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
     * @return array
     */
    public function getQueryParams()
    {
        return array(
            'limit' => 'count',
        );
    }

    /**
     * @return array
     */
    public function getRequiredParams()
    {
        return array(
            'tag'
        );
    }
}