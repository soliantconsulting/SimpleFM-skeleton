<?php
/**
 * SimpleFM_FMServer_Sample
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
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
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
                            'route'    => '/[:controller[/:action]]',
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
    'di' => array(
        'instance' => array(
            'alias' => array(
                'simple_fm' => 'Soliant\SimpleFM\Adapter',
                
                'gateway_project' => 'Application\Gateway\Project',
                'gateway_task' => 'Application\Gateway\Task',
            ),
            // simple_fm parameters included in module.config.php as a reference,
            // but will be overridden if you create environment-specific parameters
            // (for example: in /config/autoload/local.php or any autoload config)
            // in which you define simple_fm parameters in this format.
            'simple_fm' => array(
                'parameters' => array(
                    'hostParams' => array(
                        'hostname' => 'localhost',
                        'dbname'   => 'FMServer_Sample_Web',
                        'username' => 'Admin',
                        'password' => ''
                    ),
                ),
            ),
            'gateway_project' => array(
                'parameters' => array(
                    'serviceManager' => 'Zend\ServiceManager\ServiceManager',
                    'entity' => 'Application\Entity\Project',
                    'simpleFMAdapter' => 'simple_fm',
                    'layoutnamePointer' => 'ProjectPointer',
                    'layoutname' => 'Project'
                ),
            ),
            'gateway_task' => array(
                'parameters' => array(
                    'serviceManager' => 'Zend\ServiceManager\ServiceManager',
                    'entity' => 'Application\Entity\Task',
                    'simpleFMAdapter' => 'simple_fm',
                    'layoutnamePointer' => 'TaskPointer',
                    'layoutname' => 'Task',
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Project' => 'Application\Controller\ProjectController',
            'Application\Controller\Task' => 'Application\Controller\TaskController',
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
);
