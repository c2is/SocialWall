<?php

namespace C2iS\SocialWall;

use C2iS\SocialWall\Cache\CacheProviderInterface;
use C2iS\SocialWall\Exception\InvalidSocialNetworkException;
use C2iS\SocialWall\Exception\SocialNetworkNotRegisteredException;
use C2iS\SocialWall\Template\TemplateService;
use C2iS\SocialWall\Template\TemplateServiceInterface;

class SocialWall
{
    /** @var array */
    protected $params = array();

    /** @var array */
    protected $networks = array();

    /** @var array */
    protected $registeredNetworks = array();

    /** @var \C2iS\SocialWall\Template\TemplateServiceInterface */
    protected $defaultTemplateService;

    /** @var \C2iS\SocialWall\Cache\CacheProviderInterface */
    protected $cacheProvider;

    /**
     * @param array                    $params
     * @param TemplateServiceInterface $defaultTemplateService
     */
    public function __construct(array $params = array(), $defaultTemplateService = null)
    {
        $this->params = $params;

        if (null === $defaultTemplateService) {
            $defaultTemplateService = new TemplateService();
        }

        $this->registeredNetworks = array(
            'twitter'   => array(
                'manager'         => '\\C2iS\\SocialWall\\Twitter\\TwitterManager',
                'templateService' => $defaultTemplateService,
            ),
            'facebook'  => array(
                'manager'         => '\\C2iS\\SocialWall\\Facebook\\FacebookManager',
                'templateService' => $defaultTemplateService,
            ),
            'flickr'    => array(
                'manager'         => '\\C2iS\\SocialWall\\Flickr\\FlickrManager',
                'templateService' => $defaultTemplateService,
            ),
            'instagram' => array(
                'manager'         => '\\C2iS\\SocialWall\\Instagram\\InstagramManager',
                'templateService' => $defaultTemplateService,
            ),
            'google_plus' => array(
                'manager'         => '\\C2iS\\SocialWall\\GooglePlus\\GooglePlusManager',
                'templateService' => $defaultTemplateService,
            ),
            'youtube' => array(
                'manager'         => '\\C2iS\\SocialWall\\YouTube\\YouTubeManager',
                'templateService' => $defaultTemplateService,
            ),
        );

        $this->defaultTemplateService = $defaultTemplateService;
    }

    /**
     * @param \C2iS\SocialWall\Cache\CacheProviderInterface $cacheProvider
     *
     * @return $this
     */
    public function setCacheProvider(CacheProviderInterface $cacheProvider)
    {
        $this->cacheProvider = $cacheProvider;

        /** @var AbstractSocialNetwork $network */
        foreach ($this->networks as $network) {
            $network->setCacheProvider($cacheProvider);
        }

        return $this;
    }

    /**
     * @param string                   $name
     * @param string                   $class
     * @param TemplateServiceInterface $templateService
     *
     * @throws Exception\InvalidSocialNetworkException
     * @return $this
     */
    public function registerNetwork($name, $class, TemplateServiceInterface $templateService = null)
    {
        if (!(class_exists($class) && ($interfaces = class_implements(
                $class
            )) && isset($interfaces['\\C2iS\\SocialWall\\AbstractSocialNetwork']))
        ) {
            throw new InvalidSocialNetworkException(
                sprintf(
                    '"%s" does not implement the "\\C2iS\\SocialWall\\AbstractSocialNetwork" abstract class. Social networks must implement that class in order to be registrable to the SocialWall.',
                    $class
                )
            );
        }

        if (null === $templateService) {
            $templateService = $this->defaultTemplateService;
        }

        $this->registeredNetworks[$name] = array(
            'manager'         => $class,
            'templateService' => $templateService,
        );

        return $this;
    }

    /**
     * @param string $network Network name
     * @param string $id      Network API ID
     * @param string $secret  Network API secret
     *
     * @throws Exception\SocialNetworkNotRegisteredException
     * @return $this
     */
    public function initiateNetwork($networkName, $id = null, $secret = null)
    {
        if (!isset($this->registeredNetworks[$networkName])) {
            throw new SocialNetworkNotRegisteredException(
                sprintf(
                    'Social network "%s" is not defined. See \\C2iS\\SocialWall\\SocialWall::registerNetwork() for more informations.',
                    $networkName
                )
            );
        }

        $managerClass = $this->registeredNetworks[$networkName]['manager'];
        /** @var TemplateServiceInterface $templateService */
        $templateService = $this->registeredNetworks[$networkName]['templateService'];

        /** @var AbstractSocialNetwork $network */
        $network = new $managerClass($id, $secret);
        $network->setName($networkName);
        $network->setTemplateService($templateService);
        $network->setCacheProvider($this->cacheProvider);
        $this->networks[$networkName] = $network;

        return $this;
    }

    /**
     * @param $name
     *
     * @return AbstractSocialNetwork
     */
    public function getNetwork($name)
    {
        return $this->networks[$name];
    }
}
