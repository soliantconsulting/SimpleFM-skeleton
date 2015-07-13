<?php
namespace SimpleFMAuth\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Soliant\SimpleFM\ZF2\Authentication\Storage\Session as SessionStorage;


class AuthenticationStorageFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return SessionStorage
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $namespace = $config['sfm_auth']['sfm_session_namespace'];
        return new SessionStorage($namespace);
    }
}