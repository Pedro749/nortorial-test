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

        $row = $this->clientTable->getAll(['user_id' => $this->identity()->id]);


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
                $data['user_id'] = $this->identity()->id;
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

    public function editAction()
    {
        $this->layout()->setTemplate('user/layout/layout');
        $id = $this->params()->fromRoute('id');

        if (empty($id) && !$this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('client', ['action' => 'index']);
        }

        try {
            if ($this->getRequest()->isPost()) {
                $id = $this->getRequest()->getPost()->id;
            }

            $client = $this->clientTable->getBy([
                'id' => $id,
                'user_id' => $this->identity()->id
            ]);
        } catch (Exception $exception) {
            return $this->redirect()->toRoute('client', ['action' => 'index']);
        }

        $this->clientForm->bind($client);

        $viewData = ['id' => $id, 'form' => $this->clientForm->prepare()];

        if (!$this->getRequest()->isPost()) {
            return $viewData;
        }

        $this->clientForm->setData($this->getRequest()->getPost());

        if (!$this->clientForm->isValid()) {
            return $viewData;
        }

        $data = $this->clientForm->getData();

        var_dump($data);
        die;

        $this->clientTable->save($data);

        return $this->redirect()->toRoute('client', ['action' => 'index']);
    }
}
