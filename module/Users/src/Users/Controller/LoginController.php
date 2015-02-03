<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Users\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class LoginController extends AbstractActionController{
    protected $authservice;
    public function getAuthService() {
        if (!$this->authservice){
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authservice;
    }
    
    public function confirmAction() {
    	if (! $this->getServiceLocator()
    			->get('AuthService')->hasIdentity()){
    		return $this->redirect()->toRoute(NULL, array(
            'controller' => 'login',
            'action' => 'index'
        ));
    	}
    	 
        $user_email = $this->getAuthService()->getStorage()->read();
        $viewModel = new ViewModel(array(
            'user_email' => $user_email
        ));
        return $viewModel;
    }
    
    public function logoutAction() {
    	//$this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
      
        
        return $this->redirect()->toRoute(NULL, array(
            'controller' => 'login',
            'action' => 'index'
        ));
    }
    
    public function indexAction() {
        $form = $this->getServiceLocator()->get('LoginForm');
        $viewModel = new ViewModel(array(
            "form" => $form
        ));
        return $viewModel;
    }
    
    public function processAction() {
        if (!$this->request->isPost()){
            return $this->redirect()->toRoute(NULL,
                    array(
                        'controller' => 'login',
                        'action' => 'index'
                    )
            );
        }
        $post = $this->request->getPost();
        $form = $this->getServiceLocator()->get('LoginForm');
        $form->setData($post);
        
        if (!$form->isValid()){
            $model = new ViewModel(array(
                'error' => TRUE,
                  'form' => $form
            ));
            $model->setTemplate('users/login/index');
            return $model;
         }

          else {
             //check authentication
             $this->getAuthService()->getAdapter()
                     ->setIdentity($this->request->getPost('email'))         
                     ->setCredential($this->request->getPost("password"));
             $result = $this->getAuthService()->authenticate();
             if ($result->isValid()){
             	
             //	$this->getAuthService()->setStorage($this->getSessionStorage());
             	
             	
                 $this->getAuthService()->getStorage()
                         ->write($this->request->getPost('email'));
                 return $this->redirect()->toRoute(NULL, array(
                     'controller' => 'login',
                     'action' => 'confirm'
                 ));
             } else {
                 $model = new ViewModel(array(
                     'error' => true,
                     'form' => $form
                 ));
                 $model->setTemplate('users/login/index');
                 return $model;
             }
         }  
        
    }
    
    public function loginAction() {
    	
    	if ($this->getAuthService()->hasIdentity()){
    		return $this->redirect()->toRoute(NULL, array(
                     'controller' => 'login',
                     'action' => 'confirm'
                 ));
    	}
        $viewModel = new ViewModel();
        return $viewModel;
    }
}

