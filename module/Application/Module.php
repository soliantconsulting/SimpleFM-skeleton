<?php
/**
 * SimpleFM_FMServer_Sample
 * @author jsmall@soliantconsulting.com
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;

class Module
{
    public function onBootstrap($e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        /**
         * Implementing the getServiceConfig method in your Module.php is an alternative to defining
         * a 'service_manager' node in your module.config.php. It is a matter of preference where you define
         * your ServiceManager classes. They both achieve the same goal of injecting dependencies so you can
         * retrieve composed classes by name from the ServiceManager. Below is an example of composing SimpleFM
         * classes using this technique. Notice the use of a closure here for the adapter instead of a factory
         * in the module.config.php. Use of the factory requires use of the hardcoded config name
         */
        return array(
            'factories' => array(
                'alternate_simple_fm' => function ($sm) {
                    $config = $sm->get('config');
                    $hostParams = $config['simple_fm_host_params'];
                    $dbAdapter = new \Soliant\SimpleFM\Adapter($hostParams);
                    return $dbAdapter;
                },
                'alternate_gateway_project' => function ($sm) {
                    $entity = new \Application\Entity\Project();
                    $simpleFMAdapter = $sm->get('alternate_simple_fm');
                    return new \Application\Gateway\Project($entity, $simpleFMAdapter);
                },
                'alternate_gateway_task' => function ($sm) {
                    $entity = new \Application\Entity\Task();
                    $simpleFMAdapter = $sm->get('alternate_simple_fm');
                    return new \Application\Gateway\Task($entity, $simpleFMAdapter);
                },
            ),
        );
    }
}
