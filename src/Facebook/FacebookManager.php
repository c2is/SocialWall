<?php

namespace C2iS\SocialWall\Facebook;

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
    public function getResult(array $params = array(), array $queryParams = array())
    {
        $request  = new \Facebook\FacebookRequest(
            $this->session,
            'GET',
            $url = sprintf(
                '/%s/posts?%s',
                $params['user_id'],
                http_build_query(
                    array_merge(
                        array(
                            'fields' => 'privacy,message,link,name,status_type,likes,comments,type,updated_time,from,attachments'
                        ),
                        $queryParams
                    )
                )
            )
        );
        $client = $request->getHttpClientHandler();
        $client->addRequestHeader('Accept-Language', 'fr-FR,fr;q=0.8');
        $request->setHttpClientHandler($client);

        $response = $request->execute();

        $results     = isset($response->getResponse()->data) ? $response->getResponse()->data : array();
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

        $item->setCreatedAt(new \DateTime($source->created_time));

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
        $like->setName($source->name);

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
        $user->setName($source->name);

        return $user;
    }

    protected function createAttachment($source)
    {
        $attachment = new Attachment();

        $attachment->setType($source->type);
        $attachment->setUrl($source->url);
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
    public function getRequiredParams()
    {
        return array(
            'user_id',
        );
    }
}
