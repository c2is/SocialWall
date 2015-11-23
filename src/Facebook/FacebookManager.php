<?php

namespace C2iS\SocialWall\Facebook;

use C2iS\SocialWall\Exception\NotImplementedException;
use C2iS\SocialWall\Facebook\Exception\FacebookSessionException;
use C2iS\SocialWall\AbstractSocialNetwork;
use C2iS\SocialWall\Facebook\Model\Attachment;
use C2iS\SocialWall\Facebook\Model\Comment;
use C2iS\SocialWall\Facebook\Model\Like;
use C2iS\SocialWall\Facebook\Model\SocialItem;
use C2iS\SocialWall\Facebook\Model\SocialUser;
use C2iS\SocialWall\Model\SocialItemResult;
use Facebook\FacebookSession;

class FacebookManager extends AbstractSocialNetwork
{
    /** @var \Facebook\FacebookSession */
    protected $session;

    /**
     * @param string $appId
     * @param string $appSecret
     *
     * @throws Exception\FacebookSessionException
     */
    public function __construct($appId, $appSecret)
    {
        FacebookSession::setDefaultApplication($appId, $appSecret);
        $session = FacebookSession::newAppSession();

        if (!$session) {
            throw new FacebookSessionException(
                sprintf(
                    '\\C2iS\\SocialWall\\Facebook\\FacebookManager needs a valid facebook session in order to make FB API calls. Check your informations for App ID "%s"',
                    $appId
                )
            );
        }

        $this->session = $session;
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @throws Exception\InvalidFacebookParametersException
     * @return SocialItemResult
     */
    protected function retrieveItemsForUser(array $params = array(), array $queryParams = array())
    {
        $request = new \Facebook\FacebookRequest(
            $this->session,
            'GET',
            sprintf(
                '/%s/posts?%s',
                $params['user_id'],
                http_build_query(
                    array_merge(
                        array(
                            'fields'  => 'privacy,message,link,name,status_type,likes,comments,type,created_time,updated_time,from,attachments',
                            'summary' => 'true'
                        ),
                        $queryParams
                    )
                )
            )
        );
        $client  = $request->getHttpClientHandler();
        $client->addRequestHeader('Accept-Language', 'fr-FR,fr;q=0.8');
        $request->setHttpClientHandler($client);

        $response = $request->execute();

        $results = isset($response->getResponse()->data) ? $response->getResponse()->data : array();

        $socialItems = array();

        foreach ($results as $item) {
            $socialItems[] = $this->createSocialItem($item);
        }

        $result = new SocialItemResult($socialItems);
        $result->setPreviousPage($response->getResponse()->paging->previous);
        $result->setNextPage($response->getResponse()->paging->next);

        return $result;
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return \C2iS\SocialWall\Model\SocialItemResult
     * @throws \C2iS\SocialWall\Exception\NotImplementedException
     */
    protected function retrieveItemsForTag(array $params = array(), array $queryParams = array())
    {
        throw new NotImplementedException('At this time Facebook Graph API does not allow search by tags');
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
            'At this time Facebook Graph API does not provide an efficient way to get this information'
        );
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return string
     * @throws \Facebook\FacebookRequestException
     */
    protected function retrieveNumberOfSubscribers(array $params = array(), array $queryParams = array())
    {
        $request = new \Facebook\FacebookRequest(
            $this->session,
            'GET',
            sprintf(
                '/%s?fields=likes',
                $params['user_id']
            )
        );
        $client  = $request->getHttpClientHandler();
        $client->addRequestHeader('Accept-Language', 'fr-FR,fr;q=0.8');
        $request->setHttpClientHandler($client);

        $response = $request->execute();

        return (string)$response->getResponse()->likes;
    }

    /**
     * @param $source
     *
     * @return \C2iS\SocialWall\Facebook\Model\SocialItem
     */
    protected function createSocialItem($source)
    {
        $item = new SocialItem();

        $item->setId($source->id);

        if (isset($source->object_id)) {
            $item->setObjectId($source->object_id);
        }

        if (isset($source->message)) {
            $item->setMessage($source->message);
        }

        if (isset($source->attachments)) {
            foreach ($source->attachments->data as $attachment) {
                if (isset($attachment->subattachments)) {
                    foreach ($attachment->subattachments->data as $subattachment) {
                        if (isset($subattachment->media->image->src)) {
                            $item->addAttachment($this->createAttachment($subattachment));
                        }
                    }
                } elseif (isset($attachment->media->image->src)) {
                    $item->addAttachment($this->createAttachment($attachment));
                }
            }
        }

        if (isset($source->link)) {
            $item->setLink($source->link);
        }

        if (isset($source->icon)) {
            $item->setIcon($source->icon);
        }

        if (isset($source->name)) {
            $item->setName($source->name);
        }

        if (isset($source->status_type)) {
            $item->setType($source->status_type);
        }

        if (isset($source->privacy->value)) {
            $item->setPrivacy($source->privacy->value);
        }

        if (isset($source->type)) {
            $item->setType($source->type);
        }

        if (isset($source->created_time)) {
            $item->setCreatedAt(new \DateTime($source->created_time));
        }

        if (isset($source->updated_time)) {
            $item->setUpdatedAt(new \DateTime($source->updated_time));
        }

        if (isset($source->from)) {
            $item->setUser($this->createSocialUser($source->from));
        }

        if (isset($source->likes->data)) {
            $likes = array();

            foreach ($source->likes->data as $sourceLike) {
                $like = $this->createLike($sourceLike);

                if ($like) {
                    $likes[] = $like;
                }
            }

            $item->setLikes($likes);
            $item->setShares(count($likes));
        } else {
            $item->setShares(0);
        }

        if (isset($source->comments->data)) {
            $comments = array();

            foreach ($source->comments->data as $sourceComment) {
                $comment = $this->createComment($sourceComment);

                if ($comment) {
                    $comments[] = $comment;
                }
            }

            $item->setComments($comments);
        }

        return $item;
    }

    /**
     * @param object $source
     *
     * @return \C2iS\SocialWall\Facebook\Model\Like
     */
    protected function createLike($source)
    {
        $like = new Like();

        $like->setId($source->id);
        if (isset($source->name)) {
            $like->setName($source->name);
        }

        return $like;
    }

    /**
     * @param object $source
     *
     * @return \C2iS\SocialWall\Facebook\Model\Comment
     */
    protected function createComment($source)
    {
        $comment = new Comment();

        $comment->setId($source->id);
        $comment->setText($source->message);
        $comment->setUser($this->createSocialUser($source->from));
        $comment->setCreatedAt(new \DateTime($source->created_time));

        return $comment;
    }

    /**
     * @param object $source
     *
     * @return \C2iS\SocialWall\Facebook\Model\SocialUser
     */
    protected function createSocialUser($source)
    {
        $user = new SocialUser();

        $user->setId($source->id);
        if (isset($source->name)) {
            $user->setName($source->name);
        }

        return $user;
    }

    protected function createAttachment($source)
    {
        $attachment = new Attachment();

        $attachment->setType($source->type);
        $attachment->setUrl($source->url);
        $attachment->setWidth($source->media->image->width);
        $attachment->setHeight($source->media->image->height);
        $attachment->setImage($source->media->image->src);
        $attachment->setTitle(isset($source->title) ? $source->title : null);

        return $attachment;
    }

    /**
     * @return array
     */
    public function getQueryParams()
    {
        return array(
            'limit',
            'lang' => 'locale',
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
    public function getNumberOfItemsRequiredParams()
    {
        return array(
            'user_id',
            'max_iterations' => 8,
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
