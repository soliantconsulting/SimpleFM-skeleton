<?php
/**
 * SimpleFM_FMServer_Sample
 * @author jsmall@soliantconsulting.com
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\ViewModel;
use Soliant\SimpleFM\ZF2\Authentication\Mapper\Identity;

class LoginController extends AbstractActionController
{
    
    protected $form;
    protected $authService;
    protected $authAdapter;
    protected $sessionStorage;
    
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
        
        

        //if already login, redirect to success page
        if ($this->getAuthService()->hasIdentity()){
            return $this->redirect()->toRoute('home');
        }
        
        $form       = $this->getForm();
        
        $request = $this->getRequest();
        
        if ($request->isPost()){
            $form->setData($request->getPost());
            if ($form->isValid()){
                
                $authAdapter = $this->getAuthAdapter();
                $authService = $this->getAuthService();
                
                
                $authAdapter->setUsername($request->getPost('username'))
                            ->setPassword($request->getPost('password'));
    
                $result = $authService->authenticate($authAdapter);
                 
                foreach($result->getMessages() as $message)
                {
                    //save message temporary into flashmessenger
                    if (is_string($message)){
                        $this->flashmessenger()->addMessage($message);
                    }
                }
        
                if ($result->isValid()) {
                    //check if it has rememberMe :
                    if ($request->getPost('rememberme') == 1 ) {
                        $this->getSessionStorage()
                        ->setRememberMe(1);
                        //set storage again
                        $this->getAuthService()->setStorage($this->getSessionStorage());
                    }
                    return $this->redirect()->toRoute('home');
                }
            }
        } else {
            $form->setData(array('username'=>'dave@westsideantiques.com'));
        }
        
        return array(
                'form'      => $this->getForm(),
                'messages'  => $this->flashmessenger()->getMessages(),
                'installMessages' => $messages, 
                'serverIsOnline' => $serverIsOnline,
        );
        
    }
    
    public function getForm()
    {
        if (! $this->form) {
            $user       = new Identity();
            $builder    = new AnnotationBuilder();
            $this->form = $builder->createForm($user);
        }
    
        return $this->form;
    }
    
    public function getAuthService()
    {
        if (! $this->authService) {
            $this->authService = $this->getServiceLocator()
            ->get('sfm_auth_service');
        }
        return $this->authService;
    }
    
    public function getAuthAdapter()
    {
        if (! $this->authAdapter) {
            $this->authAdapter = $this->getServiceLocator()
            ->get('sfm_auth_adapter');
        }
        return $this->authAdapter;
    }
    
    public function getSessionStorage()
    {
        if (! $this->sessionStorage) {
            $this->sessionStorage = $this->getServiceLocator()
            ->get('sfm_auth_storage');
        }
        return $this->sessionStorage;
    }
}
