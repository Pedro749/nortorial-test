<?php

namespace Auth\Controller;

use Auth\Form\LoginForm;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    private $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function loginAction()
    {
        $this->layout()->setTemplate('user/layout/layout');
        $form = new LoginForm();

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $adapter = $this->authenticationService->getAdapter();
                $adapter->setEmail($form->getData()['email'])
                    ->setPassword($form->getData()['password']);

                if (!$this->authenticationService->authenticate()->isValid()) {
                    $message = $this->authenticationService->authenticate()->getMessages();
                    $this->flashMessenger()->addErrorMessage($message[0]);

                    return $this->redirect()->refresh();
                }

                return $this->redirect()->toRoute('application');
            }
        }

        return new ViewModel([
            'form' => $form->prepare()
        ]);
    }

    public function logoutAction()
    {
        $this->authenticationService->clearIdentity();
        $this->flashMessenger()->addInfoMessage('Você foi desconectado!');

        return $this->redirect()->toRoute('auth.login');
    }
}
