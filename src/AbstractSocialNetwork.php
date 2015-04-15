<?php

namespace C2iS\SocialWall;

use C2iS\SocialWall\Cache\CacheProviderInterface;
use C2iS\SocialWall\Exception\InvalidParametersException;
use C2iS\SocialWall\Model\AbstractSocialItem;
use C2iS\SocialWall\Model\SocialItemResult;
use C2iS\SocialWall\Template\TemplateServiceInterface;

abstract class AbstractSocialNetwork
{
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
     * @throws \Exception Might throw an exception if some parameters are required
     * @return SocialItemResult
     */
    abstract public function getResult(array $params = array(), array $queryParams = array());

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
     * @throws Exception\InvalidParametersException
     * @return SocialItemResult
     */
    public function getSocialItems(array $params = array())
    {
        $cacheProvider = $this->cacheProvider;

        if ($cacheProvider && $cacheProvider->isCacheFresh($this->name)) {
            return $cacheProvider->getCache($this->name);
        }

        $requiredParams  = array();
        $defaultParams   = array();
        $queryParameters = array();

        foreach ($this->getRequiredParams() as $key => $value) {
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

        try {
            $result = $this->getResult($params, $queryParameters);
        } catch (\Exception $e) {
            error_log(sprintf('Error calling API for social network %s : %s', $this->getName(), $e->getMessage()));
            $result = false;
        }

        if ($cacheProvider && $result) {
            $cacheProvider->setCache($this->name, $result);
        }

        return $result;
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
     * @return array
     */
    public function getQueryParams()
    {
        return array();
    }

    /**
     * @return array
     */
    public function getRequiredParams()
    {
        return array();
    }
}
