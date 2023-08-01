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
                unset($data['id']);

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

        $this->clientForm->get('cpf_cnpj')
            ->setAttributes(['readonly' => 'readonly']);

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
        $this->clientForm->setValidationGroup(['name', 'rg_ie', 'uf', 'city', 'address']);

        if (!$this->clientForm->isValid()) {
            return $viewData;
        }

        $data = (array) $this->clientForm->getData();
        unset($data['cpf_cnpj']);
        $this->clientTable->save($data);

        return $this->redirect()->toRoute('client', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $this->layout()->setTemplate('user/layout/layout');
        $id = $this->params()->fromRoute('id');

        if (empty($id)) {
            return $this->redirect()->toRoute('client', ['action' => 'index']);
        }

        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');

            if ($del == 'Yes') {
                $id = $this->getRequest()->getPost('id');
                $this->clientTable->delete($id);
            }

            return $this->redirect()->toRoute('client');
        }

        return [
            'id' => $id,
            'client' => $this->clientTable->getBy([
                'id' => $id,
                'user_id' => $this->identity()->id
            ]),
        ];
    }
}
