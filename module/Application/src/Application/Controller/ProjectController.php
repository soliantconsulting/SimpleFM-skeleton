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
        
        /**
         * This example demonstrates use of gateway resolveEntity() to resolve a sparse entity into a full entity
         */
        $sparseProject = $projects[0];
        $fullProject = $gatewayProject->resolveEntity($sparseProject, 'Project');
        
        return new ViewModel(array('projects' => $projects, 'sparseProject' => $sparseProject, 'fullProject' => $fullProject));
    }

    public function detailAction()
    {
        $gatewayProject = $this->getServiceLocator()->get('gateway_project');
        
        $recid = $this->getRequest()->getQuery()->get('recid');
        
        $project = $gatewayProject->find($recid);
        
        // $helloWorld = $gatewayProject->helloWorld();
        $helloWorld = 'AbstractGateway provides basic CRUD methods. Uncomment line 37 in module/Application/Controller/ProjectController.php and experiment with making your own custom Gateway methods.';
        
        return new ViewModel(array('project' => $project, 'helloWorld' => $helloWorld));
    }
}
