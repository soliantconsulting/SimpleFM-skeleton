<?php
/**
 * SimpleFM-skeleton
 * @author jsmall@soliantconsulting.com
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        	'project' => array(
        		'type' => 'Zend\Mvc\Router\Http\Literal',
        		'options' => array(
        			'route'    => '/project',
        			'defaults' => array(
        				'controller' => 'Application\Controller\Project',
        				'action'     => 'index',
        			),
        		),
        	),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Project' => 'Application\Controller\ProjectController',
            'Application\Controller\Task' => 'Application\Controller\TaskController',
            'Application\Controller\Login' => 'Application\Controller\LoginController',
            'Application\Controller\Logout' => 'Application\Controller\LogoutController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        /**
         * Notes on ServiceManager config from http://akrabat.com/zend-framework-2/zendservicemanager-configuration-keys/
         * Within the service_manager array, there are a set of nested arrays which are generally used to configure
         * how you want a given class to be instantiated. the names of these sub-arrays are hardcoded, so you just
         * need to learn their names and the difference between them:
         */
            'factories' => array(
                /**
                 * The factories node defines callbacks that return an instantiated class. This is for cases where you need
                 * to configure the instance of the object. The callback can be a class that implements
                 * Zend\ServiceManager\FactoryInterface as in the first example for the simple_fm adapter below, or
                 * it can be a closure like the gateway factories below. Note that factories can alternately be
                 * defined in a special getServiceConfig method which can be defined in Module.php. This module
                 * has an example you can look at.
                 */
                    'simple_fm' => 'Soliant\SimpleFM\ZF2\AdapterServiceFactory',
                    'gateway_project' => function ($sm) {
                        $config = $sm->get('config');
                        $entity = new \Application\Entity\Project();
                        $simpleFMAdapter = $sm->get('simple_fm');
                        return new \Application\Gateway\Project($entity, $simpleFMAdapter);
                    },
                    'gateway_task' => function ($sm) {
                        $config = $sm->get('config');
                        $entity = new \Application\Entity\Task();
                        $simpleFMAdapter = $sm->get('simple_fm');
                        return new \Application\Gateway\Task($entity, $simpleFMAdapter);
                    },


            ),
            'invokables' => array(
//                 /**
//                  * A string which is the name of a class to be instantiated. The ServiceManager will instantiate the
//                  * class for you when needed.
//                  * For example:
//                  */
//                     // example 1
//                     'session' => 'Zend\Session\Storage\SessionStorage',
//                     // example 2
//                     'zfcuser_user' => 'User\Service\User'
            ),
            'services' => array(
//                 /**
//                  * An instance of a class. This is used to register already instantiated objects with the ServiceManager.
//                  * For example:
//                  */
//                     'rob' => $rob,  // $rob is already instantiated
            ),
            'aliases' => array(
//                 /**
//                  * Another name for a class. Generally, you see this used within a module so that the module uses it's
//                  * own alias name and then the user of the module can configure exactly which class that alias name is
//                  * to be.
//                  * For example:
//                  */
//                     // example 1
//                     'mymodule_zend_db_adapter' => 'Zend\Db\Adapter\Adapter',
            ),
            'initializers' => array(
//                 /**
//                  * A callback that is executed every time the ServiceManager creates a new instance of a class. These are
//                  * usually used to inject an object into the new class instance if that class implements a particular
//                  * interface.
//                  * For example:
//                  */
//                     function ($instance, $sm) {
//                         if ($instance instanceof AuthorizeAwareInterface) {
//                             $instance->setAuthorizeService($sm->get('auth_service'));
//                         }
//                     }
//                     /**
//                      * In the case, the initialiser checks if $instance implements AuthorizeAwareInterface and if it injects
//                      * the Authorize service into the instance ready for use. Another really common use-case is injecting a
//                      * database adapter and Zend Framework supplies Zend\Db\Adapter\AdapterAwareInterface for this case.
//                      */
            ),
            'abstract_factories' => array(
//                 /**
//                  * There is also the abstract_factories key, but this is rarely used in most apps.
//                  *
//                  * A factory instance that can create multiple services based on the name supplied to the factory. This is
//                  * used to enable ServiceManager to fallback to another Service Locator system if it can cannot locate the
//                  * required class from within its own configuration. As an example, you could write an abstract factory
//                  * that proxies to Symfony's DependencyInjection component. Items within this sub-key can be either a
//                  * classname string or an instance of the factory itself
//                  * All abstract factories must implement Zend\ServiceManager\AbstractFactoryInterface.
//                  * For example:
//                  */
//                     new DiStrictAbstractServiceFactory(),
            ),
    ),
);
