<?php

namespace C2iS\SocialWall;

use C2iS\SocialWall\Cache\CacheProviderInterface;
use C2iS\SocialWall\Exception\InvalidParametersException;
use C2iS\SocialWall\Model\AbstractSocialItem;
use C2iS\SocialWall\Model\SocialItemResult;
use C2iS\SocialWall\Template\TemplateServiceInterface;

/**
 * Class AbstractSocialNetwork
 *
 * @package C2iS\SocialWall
 */
abstract class AbstractSocialNetwork
{
    const CALL_ITEMS_FOR_USER = 'itemsForUser';
    const CALL_ITEMS_FOR_TAG = 'itemsForTag';
    const CALL_ITEMS_FOR_LOCATION = 'itemsForLocation';
    const CALL_NUMBER_OF_ITEMS = 'numberOfItems';
    const CALL_NUMBER_OF_SUBSCRIBERS = 'numberOfSubscribers';
    const CACHE_ITEMS = 100;

    /** @var string */
    protected $name;

    /** @var TemplateServiceInterface */
    protected $templateService;

    /** @var \C2iS\SocialWall\Cache\CacheProviderInterface */
    protected $cacheProvider;

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return SocialItemResult
     */
    abstract protected function retrieveItemsForUser(array $params = array(), array $queryParams = array());

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return SocialItemResult
     */
    abstract protected function retrieveItemsForTag(array $params = array(), array $queryParams = array());

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return SocialItemResult
     */
    abstract protected function retrieveItemsForLocation(array $params = array(), array $queryParams = array());

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return string
     */
    abstract protected function retrieveNumberOfItems(array $params = array(), array $queryParams = array());

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @return string
     */
    abstract protected function retrieveNumberOfSubscribers(array $params = array(), array $queryParams = array());

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param TemplateServiceInterface $templateService
     *
     * @return $this
     */
    public function setTemplateService($templateService)
    {
        $this->templateService = $templateService;

        return $this;
    }

    /**
     * @param \C2iS\SocialWall\Cache\CacheProviderInterface $cacheProvider
     *
     * @return $this
     */
    public function setCacheProvider(CacheProviderInterface $cacheProvider = null)
    {
        $this->cacheProvider = $cacheProvider;

        return $this;
    }

    /**
     * @param array $params
     *
     * @return bool|\C2iS\SocialWall\Model\SocialItemResult
     * @throws \C2iS\SocialWall\Exception\InvalidParametersException
     * @throws \C2iS\SocialWall\Exception\NotImplementedException
     */
    public function getItemsForUser(array $params = array())
    {
        return $this->execute(self::CALL_ITEMS_FOR_USER, $params);
    }

    /**
     * @param array $params
     *
     * @return bool|\C2iS\SocialWall\Model\SocialItemResult
     * @throws \C2iS\SocialWall\Exception\InvalidParametersException
     * @throws \C2iS\SocialWall\Exception\NotImplementedException
     */
    public function getItemsForTag(array $params = array())
    {
        return $this->execute(self::CALL_ITEMS_FOR_TAG, $params);
    }

    /**
     * @param array $params
     *
     * @return bool|\C2iS\SocialWall\Model\SocialItemResult
     * @throws \C2iS\SocialWall\Exception\InvalidParametersException
     * @throws \C2iS\SocialWall\Exception\NotImplementedException
     */
    public function getItemsForLocation(array $params = array())
    {
        return $this->execute(self::CALL_ITEMS_FOR_LOCATION, $params);
    }

    /**
     * @param array $params
     *
     * @return string
     * @throws \C2iS\SocialWall\Exception\InvalidParametersException
     * @throws \C2iS\SocialWall\Exception\NotImplementedException
     */
    public function getNumberOfItems(array $params = array())
    {
        return $this->execute(self::CALL_NUMBER_OF_ITEMS, $params);
    }

    /**
     * @param array $params
     *
     * @return string
     * @throws \C2iS\SocialWall\Exception\InvalidParametersException
     * @throws \C2iS\SocialWall\Exception\NotImplementedException
     */
    public function getNumberOfSubscribers(array $params = array())
    {
        return $this->execute(self::CALL_NUMBER_OF_SUBSCRIBERS, $params);
    }

    /**
     * @param \C2iS\SocialWall\Model\AbstractSocialItem $socialItem
     *
     * @return string
     */
    public function renderSocialItem(AbstractSocialItem $socialItem)
    {
        return $this->templateService->render($socialItem);
    }

    /**
     * @param string $call
     * @param array  $params
     *
     * @return bool|\C2iS\SocialWall\Model\SocialItemResult
     * @throws \C2iS\SocialWall\Exception\InvalidParametersException
     * @throws \C2iS\SocialWall\Exception\NotImplementedException
     */
    protected function execute($call, array $params = array())
    {
        $cacheProvider = $this->cacheProvider;
        $limit         = isset($params['limit']) ? $params['limit'] : null;
        $useCache      = (!isset($params['cache_disable']) || !$params['cache_disable']) && $cacheProvider;
        $initialParams = $params;

        if ($useCache && $cacheProvider->isCacheFresh(
                $this->name,
                $call,
                $initialParams
            ) && ($cacheResult = $cacheProvider->getCache($this->name, $call, $initialParams))
        ) {
            return $cacheResult;
        }

        // If generating cache, ups the number of items retrieved from webservices
        if ($useCache) {
            $params['limit'] = self::CACHE_ITEMS;
        }

        $queryParameters = $this->processParams($params, $call);
        $callMethodName  = sprintf('retrieve%s', ucfirst($call));

        try {
            /** @var SocialItemResult $result */
            $result = $this->$callMethodName($params, $queryParameters);
        } catch (\Exception $e) {
            error_log(
                sprintf('Error calling API for social network %s (%s) : %s', $this->getName(), $call, $e->getMessage())
            );
            $result = false;
        }

        if ($useCache && $result) {
            $cacheProvider->setCache($this->name, $call, $result, $initialParams);

            if (is_object($result)) {
                $result->setItems(array_slice($result->getItems(), 0, $limit));
            }
        }

        return $result;
    }

    /**
     * @param array  $params
     * @param string $call
     *
     * @return array
     * @throws \C2iS\SocialWall\Exception\InvalidParametersException
     */
    protected function processParams(array &$params, $call)
    {
        $requiredParams          = array();
        $defaultParams           = array();
        $queryParameters         = array();
        $requiredParamMethodName = sprintf('get%sRequiredParams', ucfirst($call));

        foreach ($this->getRequiredParams() as $key => $value) {
            if (is_string($key)) {
                $defaultParams[$key] = $value;
            } else {
                $requiredParams[] = $value;
            }
        }

        foreach ($this->$requiredParamMethodName() as $key => $value) {
            if (is_string($key)) {
                $defaultParams[$key] = $value;
            } else {
                $requiredParams[] = $value;
            }
        }

        if ($missingParams = array_diff($requiredParams, array_keys($params))) {
            throw new InvalidParametersException(
                sprintf(
                    'Some required parameters are missing (%s), given (%s)',
                    implode(', ', array_values($missingParams)),
                    implode(', ', array_keys($params))
                )
            );
        }

        if ($missingParams = array_diff($defaultParams, array_keys($params))) {
            foreach ($missingParams as $paramName => $paramDefaultValue) {
                $params[$paramName] = $paramDefaultValue;
            }
        }

        foreach ($this->getQueryParams() as $inputName => $outputName) {
            if (!is_string($inputName)) {
                $inputName = $outputName;
            }

            if (isset($params[$inputName])) {
                $queryParameters[$outputName] = $params[$inputName];
                unset($params[$inputName]);
            }
        }

        return $queryParameters;
    }

    /**
     * @return array
     */
    protected function getQueryParams()
    {
        return array();
    }

    /**
     * @return array
     */
    protected function getRequiredParams()
    {
        return array();
    }

    /**
     * @return array
     */
    protected function getItemsForUserRequiredParams()
    {
        return array();
    }

    /**
     * @return array
     */
    protected function getItemsForTagRequiredParams()
    {
        return array();
    }

    /**
     * @return array
     */
    protected function getItemsForLocationRequiredParams()
    {
        return array();
    }

    /**
     * @return array
     */
    protected function getNumberOfItemsRequiredParams()
    {
        return array();
    }

    /**
     * @return array
     */
    protected function getNumberOfSubscribersRequiredParams()
    {
        return array();
    }
}
