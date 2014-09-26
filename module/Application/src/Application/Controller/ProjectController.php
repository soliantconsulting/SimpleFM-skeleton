<?php
/**
 * SimpleFM_FMServer_Sample
 * @author jsmall@soliantconsulting.com
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \Application\Entity\Project AS ProjectEntity;

class ProjectController extends AbstractActionController
{
    public function indexAction()
    {
    	$gatewayProject = $this->getServiceLocator()->get('gateway_project');
    	
    	$formManager = $this->serviceLocator->get('FormElementManager');
    	$form = $formManager->get('add_project');
    	
    	$project = new ProjectEntity();
    	$form->bind($project);

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setData($request->getPost());
    		if ($form->isValid()){
    			$gatewayProject->create($project);
    			$this->flashMessenger()->addSuccessMessage('Project added successfully.');
    			$this->redirect()->toRoute('project');
    		}
    	}
    	
        $gatewayProject->setEntityLayout('ProjectPointer');
        $projects = $gatewayProject->findAll();
        
        /**
         * This example demonstrates use of gateway resolveEntity() to resolve a sparse entity into a full entity
         */
        $sparseProject = $projects[0];
        $fullProject = $gatewayProject->resolveEntity($sparseProject, 'Project');
        
        return new ViewModel(
        	array(
        		'projects' => $projects, 
        		'sparseProject' => $sparseProject, 
        		'fullProject' => $fullProject,
        		'addProject' => $form
        	)
        );
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
