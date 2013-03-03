<?php
/**
 * SimpleFM_FMServer_Sample
 * @author jsmall@soliantconsulting.com
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProjectController extends AbstractActionController
{
    public function indexAction()
    {
        $gatewayProject = $this->getServiceLocator()->get('gateway_project');
        $gatewayProject->setEntityLayout('ProjectPointer');
        
        $projects = $gatewayProject->findAll();
        
        \Zend\Debug\Debug::dump($projects[0]);
        
        $fullProject = $gatewayProject->resolveEntity($projects[0], 'Project');
        
        \Zend\Debug\Debug::dump($fullProject);
        
        return new ViewModel(array('projects' => $projects));
    }

    public function detailAction()
    {
        $gatewayProject = $this->getServiceLocator()->get('gateway_project');
        
        $recid = $this->getRequest()->getQuery()->get('recid');
        
        $project = $gatewayProject->find($recid);
        
        \Zend\Debug\Debug::dump($project);
        
        // $helloWorld = $gatewayProject->helloWorld();
        $helloWorld = 'AbstractGateway provides basic CRUD methods. Uncomment line 31 in ProjectController and experiment with custom Gateway methods.';
        
        return new ViewModel(array('project' => $project, 'helloWorld' => $helloWorld));
    }
}
