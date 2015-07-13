<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 7/12/15
 * Time: 7:35 PM
 */

namespace Application\Gateway\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Entity\Task as Entity;
use Application\Gateway\Task as Gateway;

class TaskGatewayFactory implements FactoryInterface
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