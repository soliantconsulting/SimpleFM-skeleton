<?php
/**
 * SimpleFM_FMServer_Sample
 * @author jsmall@soliantconsulting.com
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Soliant\SimpleFM\Adapter;
use Soliant\SimpleFM\Result\FmResultSet;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        /** @var Adapter $adapter */
        $adapter = $this->getServiceLocator()->get('simple_fm');

        /** @var FmResultSet $result */
        $result = $adapter->setLayoutname('Project')->execute();
        
        if ($result->getErrorCode() === 0){
            $messages = $adapter->getHostConnection()->getDbName() . ' is hosted on ' . $adapter->getHostConnection()->getHostname() . '.';
            $serverIsOnline = TRUE;
        } else {
            $messages[] = 'Error Type: '  . $result->getErrorType();
            $messages[] = 'Error Code: '  . $result->getErrorCode();
            $messages[] = 'Error Message: '  . $result->getErrorMessage();
            $messages[] = 'Adapter Debug URL: ' . $result->getDebugUrl();
            $serverIsOnline = FALSE;
        }
        
        return new ViewModel(array('messages' => $messages, 'serverIsOnline' => $serverIsOnline));
    }
}
