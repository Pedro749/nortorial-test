<?php

namespace Client\Controller;

use Exception;
use Client\Form\ClientForm;
use Client\Model\ClientTable;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    private $clientForm;
    private $clientTable;

    public function __construct(ClientForm $clientForm, ClientTable $clientTable)
    {
        $this->clientForm = $clientForm;
        $this->clientTable = $clientTable;
    }

    public function indexAction()
    {
        $this->layout()->setTemplate('layout/layout');

        $row = $this->clientTable->getAll();

        return new ViewModel([
            'clients' => $row
        ]);
    }

    public function registerAction()
    {
        $this->layout()->setTemplate('user/layout/layout');

        if ($this->getRequest()->isPost()) {
            $this->clientForm->setData($this->getRequest()->getPost());
            if ($this->clientForm->isValid()) {
                $data = $this->clientForm->getData();
                try {
                    $this->clientTable->save($data);
                    $this->flashMessenger()->addSuccessMessage(
                        sprintf(
                            'Cliente cadastrado!'
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
            'form' => $this->clientForm->prepare()
        ]);
    }
}
