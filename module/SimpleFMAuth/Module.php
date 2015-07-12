<?php

namespace SimpleFMAuth;

use Zend\Validator\InArray;

use Zend\ModuleManager\ModuleManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\Mvc\MvcEvent;
use Soliant\SimpleFM\HostConnection;

class Module implements EventManagerAwareInterface
{

    protected $events;

    public function init(ModuleManager $moduleManager)
    {
        $this->getEventManager()->getSharedManager()->attach(
            array('Zend\Mvc\Application'),    // context
            array(MvcEvent::EVENT_DISPATCH),  // event 'dispatch'
            array($this, 'checkSession')      // callback
        );
    }

    public function getEventManager()
    {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }

    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers(array(
            __CLASS__,
            get_called_class(),
        ));
        $this->events = $events;
        return $this;
    }

    public function onBootstrap($e) {

    }

    public function checkSession($e)
    {
        $controller = $e->getTarget(); // grab Controller instance from event

        $app              = $e->getApplication();
        $sm               = $app->getServiceManager();
        $allConfig        = $sm->get('config');
        $config           = $allConfig['sfm_auth'];
        
        $needle           = get_class($controller);
        $haystack         = $config['sfm_exempt_controllers'];
        $controllerExempt = in_array($needle, $haystack);
        
        $authService = $sm->get('sfm_auth_service');
        $authAdapter = $sm->get('sfm_auth_adapter');
        
        /**
         * If authenticated, add menu and whatnot 
         */
        if ($authService->hasIdentity()){
            $application = $e->getParam('application');
            $viewModel = $application->getMvcEvent()->getViewModel();
            $viewModel->authenticatedUser = $authService->getIdentity();
            
            // $serviceManager = $e->getApplication()->getServiceManager();
            // $viewModel = $e->getViewModel();
            // $container = $serviceManager->get('navigation');
            // $viewModel->setVariable('navbar', $container);
        }

        /**
         * If not in an exempt controller, and still have no identity, bail to login page
         */
        if (!$controllerExempt && !$authService->hasIdentity()) {
            $loginRoute = $config['sfm_login_route'];
            header("Location: $loginRoute");
            $e->stopPropagation();
            die();
        }

        return TRUE;

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
        return array(
            'factories' => array(
                'sfm_validation_adapter' => function ($sm) {
                    $config = $sm->get('config');
                    $hostParams = $config['sfm_auth']['simple_fm_host_params'];
                    $dbAdapter = new \Soliant\SimpleFM\Adapter(
                        new HostConnection(
                            $hostParams['hostName'],
                            $hostParams['dbName'],
                            null,
                            null
                        )
                    );
                    return $dbAdapter;
                },
                'sfm_auth_adapter' => function ($sm) {
                    $config = $sm->get('config');
                    $authConfig = $config['sfm_auth']['sfm_auth_params'];
                    $validateSimpleFmAdapter = $sm->get('sfm_validation_adapter');
                    return new \Soliant\SimpleFM\ZF2\Authentication\Adapter\SimpleFM($authConfig, $validateSimpleFmAdapter);
                },
                'sfm_auth_storage' => function ($sm) {
                    $config = $sm->get('config');
                    $namespace = $config['sfm_auth']['sfm_session_namespace'];
                    return new \Soliant\SimpleFM\ZF2\Authentication\Storage\Session($namespace);
                },
                'sfm_auth_service' => function ($sm) {
                    $storage = $sm->get('sfm_auth_storage');
                    return new \Zend\Authentication\AuthenticationService($storage);
                },
            ),
        );
    }
}
