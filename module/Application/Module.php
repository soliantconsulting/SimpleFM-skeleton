<?php
/**
 * SimpleFM-skeleton
 * @author jsmall@soliantconsulting.com
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class Module
{
    public function onBootstrap($e)
    {
        $eventManager = $e->getApplication()->getEventManager();
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

    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                'add_project' => function ($sm) {
                    $form = new \Application\Form\AddProject();
                    $form->setInputFilter(new \Application\Form\Filter\AddProject());
                    $form->setHydrator(new ClassMethodsHydrator());
                    return $form;
                },
            ),
        );
    }
}
