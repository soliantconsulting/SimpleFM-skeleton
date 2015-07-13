<?php
namespace SimpleFMAuth\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter\AdapterInterface;
use Soliant\SimpleFM\ZF2\Authentication\Adapter\SimpleFM as SimpleFmAuthAdapter;
use Soliant\SimpleFM\Adapter as SimpleFmAdapter;

class AuthenticationAdapterFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return AdapterInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var array $authConfig */
        $authConfig = $serviceLocator->get('config')['sfm_auth']['sfm_auth_params'];

        /** @var SimpleFmAdapter $validateSimpleFmAdapter */
        $validateSimpleFmAdapter = $serviceLocator->get('sfm_validation_adapter');

        return new SimpleFmAuthAdapter($authConfig, $validateSimpleFmAdapter);
    }
}