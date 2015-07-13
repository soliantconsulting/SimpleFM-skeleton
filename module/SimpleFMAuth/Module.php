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
}
