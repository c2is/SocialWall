<?php

namespace C2iS\SocialWall\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use C2iS\SocialWall\AbstractSocialNetwork;
use C2iS\SocialWall\Model\SocialItemResult;
use C2iS\SocialWall\Twitter\Exception\TwitterRequestException;
use C2iS\SocialWall\Twitter\Model\Hashtag;
use C2iS\SocialWall\Twitter\Model\Media;
use C2iS\SocialWall\Twitter\Model\SocialItem;
use C2iS\SocialWall\Twitter\Model\SocialUser;
use C2iS\SocialWall\Twitter\Model\Url;
use C2iS\SocialWall\Twitter\Model\UserMention;

class TwitterManager extends AbstractSocialNetwork
{
    /** @var \Abraham\TwitterOAuth\TwitterOAuth */
    protected $connection;

    /**
     * @param string $consumerKey
     * @param string $consumerSecret
     */
    public function __construct($consumerKey, $consumerSecret)
    {
        $this->connection = new TwitterOAuth($consumerKey, $consumerSecret);
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @throws Exception\TwitterRequestException
     * @return SocialItemResult
     */
    protected function retrieveItemsForUser(array $params = array(), array $queryParams = array())
    {
        if (is_array($queryParams['q'])) {
            $queryParams['q'] = implode(' OR ', $queryParams['q']);
        }

        if (!$params['retweet']) {
            $queryParams['q'] .= ' -RT';
        }

        $response = $this->connection->get('/statuses/user_timeline', $queryParams);

        if (isset($response->errors)) {
            $error = $response->errors[0];
            throw new TwitterRequestException($error->message, $error->code);
        }

        $results     = isset($response->statuses) ? $response->statuses : array();
        $socialItems = array();

        foreach ($results as $item) {
            $socialItems[] = $this->createSocialItem($item);
        }

        $result = new SocialItemResult($socialItems);
        $result->setPreviousPage(
            isset($response->search_metadata->previous_results) ? $response->search_metadata->previous_results : null
        );
        $result->setNextPage(
            isset($response->search_metadata->next_results) ? $response->search_metadata->next_results : null
        );

        return $result;
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @throws Exception\TwitterRequestException
     * @return SocialItemResult
     */
    protected function retrieveItemsForTag(array $params = array(), array $queryParams = array())
    {
        if (is_array($queryParams['q'])) {
            $queryParams['q'] = implode(' OR ', $queryParams['q']);
        }

        if (!$params['retweet']) {
            $queryParams['q'] .= ' -RT';
        }

        $response = $this->connection->get('/search/tweets', $queryParams);

        if (isset($response->errors)) {
            $error = $response->errors[0];
            throw new TwitterRequestException($error->message, $error->code);
        }

        $results     = isset($response->statuses) ? $response->statuses : array();
        $socialItems = array();

        foreach ($results as $item) {
            $socialItems[] = $this->createSocialItem($item);
        }

        $result = new SocialItemResult($socialItems);
        $result->setPreviousPage(
            isset($response->search_metadata->previous_results) ? $response->search_metadata->previous_results : null
        );
        $result->setNextPage(
            isset($response->search_metadata->next_results) ? $response->search_metadata->next_results : null
        );

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
        $response = $this->connection->get('/users/show/followers_count', $queryParams);

        return (string)$response->statuses_count;
    }

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return mixed
     */
    protected function retrieveNumberOfSubscribers(array $params = array(), array $queryParams = array())
    {
        $response = $this->connection->get('/users/show/followers_count', $queryParams);

        return (string)$response->followers_count;
    }

    /**
     * @param $source
     *
     * @return \C2iS\SocialWall\Twitter\Model\SocialItem
     */
    protected function createSocialItem($source)
    {
        $item = new SocialItem();
        $item->setId($source->id_str);
        $item->setLocale($source->metadata->iso_language_code);
        $item->setResultType($source->metadata->result_type);
        $item->setCreatedAt(new \DateTime($source->created_at));
        $item->setText($source->text);
        $item->setSource($source->source);
        $item->setTruncated($source->truncated);
        $item->setReply(
            array(
                SocialItem::REPLY_STATUS      => $source->in_reply_to_status_id_str,
                SocialItem::REPLY_USER        => $source->in_reply_to_user_id_str,
                SocialItem::REPLY_SCREEN_NAME => $source->in_reply_to_screen_name,
            )
        );

        if ($source->geo) {
            $item->setLatitude($source->geo->coordinates[0]);
            $item->setLongitude($source->geo->coordinates[1]);
        }

        if ($source->place) {
            $item->setPlace($source->place->full_name);
        }

        $item->setContributors($source->contributors);
        $item->setRetweetCount($source->retweet_count);
        $item->setFavoriteCount($source->favorite_count);
        $item->setFavorited($source->favorited);
        $item->setRetweeted($source->retweeted);
        $item->setSensitive(isset($source->possibly_sensitive) ? $source->possibly_sensitive : false);
        $item->setUser($this->createSocialUser($source->user));

        if (isset($source->entities->user_mentions)) {
            $userMentions = array();

            foreach ($source->entities->user_mentions as $userMention) {
                $userMentions[] = $this->createUserMention($userMention);
            }

            $item->setUserMentions($userMentions);
        }

        if (isset($source->entities->media)) {
            $medias = array();

            foreach ($source->entities->media as $media) {
                $medias[] = $this->createMedia($media);
            }

            $item->setMedias($medias);
        }

        if (isset($source->entities->hashtags)) {
            $hashtags = array();

            foreach ($source->entities->hashtags as $sourceHashtag) {
                $hashtag = $this->createHashtag($sourceHashtag);

                if ($hashtag) {
                    $hashtags[] = $hashtag;
                }
            }

            $item->setHashtags($hashtags);
        }

        if (isset($source->entities->urls)) {
            $urls = array();

            foreach ($source->entities->urls as $sourceUrl) {
                $url = $this->createUrl($sourceUrl);

                if ($url) {
                    $urls[] = $url;
                }
            }

            $item->setUrls($urls);
        }

        return $item;
    }

    /**
     * @param $source
     *
     * @return \C2iS\SocialWall\Twitter\Model\SocialUser
     */
    protected function createSocialUser($source)
    {
        $user = new SocialUser();

        if (isset($source->id_str)) {
            $user->setId($source->id_str);
        }
        if (isset($source->name)) {
            $user->setName($source->name);
        }
        if (isset($source->screen_name)) {
            $user->setScreenName($source->screen_name);
        }
        if (isset($source->location)) {
            $user->setLocation($source->location);
        }
        if (isset($source->description)) {
            $user->setDescription($source->description);
        }
        if (isset($source->protected)) {
            $user->setProtected($source->protected);
        }
        if (isset($source->url)) {
            $user->setUrl($source->url);
        }
        if (isset($source->followers_count)) {
            $user->setFollowers($source->followers_count);
        }
        if (isset($source->friends_count)) {
            $user->setFriends($source->friends_count);
        }
        if (isset($source->listed_count)) {
            $user->setListed($source->listed_count);
        }
        if (isset($source->favourites_count)) {
            $user->setFavourites($source->favourites_count);
        }
        if (isset($source->created_at) && $source->created_at) {
            $user->setCreatedAt(new \DateTime($source->created_at));
        }
        if (isset($source->time_zone)) {
            $user->setTimezone($source->time_zone);
        }
        if (isset($source->verified)) {
            $user->setVerified($source->verified);
        }
        if (isset($source->lang)) {
            $user->setLocale($source->lang);
        }

        return $user;
    }

    /**
     * @param $source
     *
     * @return UserMention
     */
    protected function createUserMention($source)
    {
        $userMention = new UserMention();
        if (isset($source->id_str)) {
            $userMention->setId($source->id_str);
        }
        if (isset($source->screen_name)) {
            $userMention->setScreenName($source->screen_name);
        }
        if (isset($source->name)) {
            $userMention->setName($source->name);
        }

        return $userMention;
    }

    /**
     * @param $source
     *
     * @return Media
     */
    protected function createMedia($source)
    {
        if ($source) {
            $media = new Media();
            if (isset($source->id_str)) {
                $media->setId($source->id_str);
            }
            if (isset($source->media_url)) {
                $media->setMediaUrl($source->media_url);
            }
            if (isset($source->media_url_https)) {
                $media->setMediaSecureUrl($source->media_url_https);
            }
            if (isset($source->url)) {
                $media->setUrl($source->url);
            }
            if (isset($source->display_url)) {
                $media->setDisplayUrl($source->display_url);
            }
            if (isset($source->type)) {
                $media->setType($source->type);
            }

            return $media;
        }

        return null;
    }

    /**
     * @param $source
     *
     * @return Hashtag
     */
    protected function createHashtag($source)
    {
        if ($source && isset($source->text)) {
            $hashtag = new Hashtag();
            $hashtag->setText($source->text);

            return $hashtag;
        }

        return null;
    }

    /**
     * @param $source
     *
     * @return Url
     */
    protected function createUrl($source)
    {
        if ($source && isset($source->url)) {
            $url = new Url();
            $url->setUrl($source->url);

            if (isset($source->expanded_url)) {
                $url->setExpandedUrl($source->expanded_url);
            }

            return $url;
        }

        return null;
    }

    /**
     * @return array
     */
    public function getQueryParams()
    {
        return array(
            'limit' => 'count',
            'query' => 'q',
            'result_type',
            'lang',
            'user_id',
        );
    }

    /**
     * @return array
     */
    public function getRequiredParams()
    {
        return array(
            'q'           => '',
            'result_type' => 'recent',
        );
    }

    /**
     * @return array
     */
    protected function getItemsForUserRequiredParams()
    {
        return array(
            'retweet' => false,
            'user_id',
        );
    }

    /**
     * @return array
     */
    protected function getItemsForTagRequiredParams()
    {
        return array(
            'retweet' => false,
        );
    }

    /**
     * @return array
     */
    protected function getNumberOfItemsRequiredParams()
    {
        return array(
            'user_id',
        );
    }

    /**
     * @return array
     */
    protected function getNumberOfSubscribersRequiredParams()
    {
        return array(
            'user_id',
        );
    }
}
