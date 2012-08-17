<?php
/**
 * SimpleFM_FMServer_Sample
 * @author jsmall@soliantconsulting.com
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $adapter = $this->getServiceLocator()->get('simple_fm');
        $result = $adapter->setLayoutname('Project')->execute();
        
        if ($result['error'] === 0){
            $messages = $adapter->getDbname() . ' is hosted on ' . $adapter->getHostname() . '.';
            $serverIsOnline = TRUE;
        } else {
            $messages[] = 'Error Type: '  . $result['errortype'];
            $messages[] = 'Error Code: '  . $result['error'];
            $messages[] = 'Error Text: '  . $result['errortext'];
            $messages[] = 'Adapter URL: ' . $result['url'];
            $serverIsOnline = FALSE;
        }
        
        return new ViewModel(array('messages' => $messages, 'serverIsOnline' => $serverIsOnline));
    }
}
