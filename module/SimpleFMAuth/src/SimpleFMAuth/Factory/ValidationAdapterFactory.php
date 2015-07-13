<?php
namespace SimpleFMAuth\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Soliant\SimpleFM\HostConnection;
use Soliant\SimpleFM\Adapter as SimpleFmAdapter;

class ValidationAdapterFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return SimpleFmAdapter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $hostParams = $config['sfm_auth']['simple_fm_host_params'];
        $dbAdapter = new SimpleFmAdapter(
            new HostConnection(
                $hostParams['hostName'],
                $hostParams['dbName'],
                null,
                null
            )
        );
        return $dbAdapter;
    }
}