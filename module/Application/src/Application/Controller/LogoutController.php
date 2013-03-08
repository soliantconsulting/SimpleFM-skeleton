<?php
/**
 * SimpleFM_FMServer_Sample
 * @author jsmall@soliantconsulting.com
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LogoutController extends AbstractActionController
{
    
    public function indexAction()
    {
        
        $this->getServiceLocator()->get('sfm_auth_service')->clearIdentity();
//         $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer')->navigation()->getContainer()->removePages();
        
        session_unset();
        session_destroy();
        session_write_close();
        
    }
    
}
