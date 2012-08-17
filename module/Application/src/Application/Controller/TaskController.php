<?php
/**
 * SimpleFM_FMServer_Sample
 * @author jsmall@soliantconsulting.com
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TaskController extends AbstractActionController
{
    public function indexAction()
    {
        $gatewayTask = $this->getServiceLocator()->get('gateway_task');
    
        $tasks = $gatewayTask->findAll();
        
        return new ViewModel(array('tasks' => $tasks));
    }

    public function detailAction()
    {
        $gatewayTask = $this->getServiceLocator()->get('gateway_task');
        
        $recid = $this->getRequest()->getQuery()->get('recid');
        
        $task = $gatewayTask->find($recid);
        
        return new ViewModel(array('task' => $task));
    }
}
