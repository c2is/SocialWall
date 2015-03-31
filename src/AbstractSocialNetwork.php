<?php

namespace C2iS\SocialWall;

use C2iS\SocialWall\Exception\InvalidParametersException;
use C2iS\SocialWall\Model\SocialItemInterface;
use C2iS\SocialWall\Model\SocialItemResult;
use C2iS\SocialWall\Template\TemplateServiceInterface;

abstract class AbstractSocialNetwork
{
    /** @var TemplateServiceInterface */
    protected $templateService;

    /**
     * @param array $params
     * @param array $queryParams
     *
     * @throws \Exception Might throw an exception if some parameters are required
     * @return SocialItemResult
     */
    abstract public function getResult(array $params = array(), array $queryParams = array());

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
     * @param array $params
     *
     * @throws Exception\InvalidParametersException
     * @return SocialItemResult
     */
    public function getSocialItems(array $params = array())
    {
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

        return $this->getResult($params, $queryParameters);
    }

    /**
     * @param \C2iS\SocialWall\Model\SocialItemInterface $socialItem
     *
     * @return string
     */
    public function renderSocialItem(SocialItemInterface $socialItem)
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
