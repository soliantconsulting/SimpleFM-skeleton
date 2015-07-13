<?php

namespace Application\Gateway\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Entity\Project as Entity;
use Application\Gateway\Project as Gateway;

class ProjectGatewayFactory implements FactoryInterface
{
    /**
     * Create db adapter service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Gateway
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $entity = new Entity();
        $simpleFMAdapter = $serviceLocator->get('simple_fm');
        return new Gateway($entity, $simpleFMAdapter);
    }
}