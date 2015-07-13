<?php
namespace SimpleFMAuth\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\AuthenticationService;
use Soliant\SimpleFM\ZF2\Authentication\Storage\Session as SessionStorage;

class AuthenticationServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return AuthenticationService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var SessionStorage $storage */
        $storage = $serviceLocator->get('sfm_auth_storage');
        return new AuthenticationService($storage);
    }
}