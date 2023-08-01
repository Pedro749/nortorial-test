<?php

namespace User\Controller;

use Exception;
use User\Form\UserForm;
use User\Model\UserTable;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    private $userForm;
    private $userTable;

    public function __construct(UserForm $userForm, UserTable $userTable)
    {
        $this->userForm = $userForm;
        $this->userTable = $userTable;
    }

    public function registerAction()
    {
        $this->layout()->setTemplate('user/layout/layout');

        if ($this->getRequest()->isPost()) {
            $this->userForm->setData($this->getRequest()->getPost());

            if ($this->userForm->isValid()) {
                $data = $this->userForm->getData();
                try {
                    $this->userTable->save($data);
                    $this->flashMessenger()->addSuccessMessage(
                        sprintf(
                            'Usuário cadastrado!'
                        )
                    );
                } catch (Exception $exception) {
                    $this->flashMessenger()->addErrorMessage(
                        'Houve um erro no cadastro!'
                    );
                }

                return $this->redirect()->refresh();
            }
        }

        return new ViewModel([
            'form' => $this->userForm->prepare()
        ]);
    }
}
