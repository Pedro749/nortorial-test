<?php

namespace Protocol\Controller;

use Exception;
use Mpdf\Mpdf;
use Zend\View\Model\ViewModel;
use Protocol\Form\ProtocolForm;
use Protocol\Model\ProtocolTable;
use Zend\View\Renderer\RendererInterface;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    private $protocolForm;
    private $protocolTable;

    public function __construct(ProtocolForm $protocolForm, ProtocolTable $protocolTable, RendererInterface $renderer)
    {
        $this->protocolForm = $protocolForm;
        $this->protocolTable = $protocolTable;
        $this->renderer = $renderer;
    }

    public function indexAction()
    {
        $this->layout()->setTemplate('layout/layout');

        $paginator = $this->protocolTable->findAll([
            'user_id' => $this->identity()->id
        ], true);

        $page = (int) $this->params()->fromQuery('page', 1);
        $page = ($page < 1) ? 1 : $page;
        $paginator->setCurrentPageNumber($page);

        $paginator->setItemCountPerPage(10);

        return new ViewModel(['paginator' => $paginator]);
    }

    public function registerAction()
    {
        $this->layout()->setTemplate('user/layout/layout');

        if ($this->getRequest()->isPost()) {
            $this->protocolForm->setData($this->getRequest()->getPost());

            if ($this->protocolForm->isValid()) {
                $data = $this->protocolForm->getData();
                $data['user_id'] = $this->identity()->id;
                unset($data['id']);

                try {
                    $this->protocolTable->save($data);
                    $this->flashMessenger()->addSuccessMessage(
                        sprintf(
                            'Protocolo cadastrado!'
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
            'form' => $this->protocolForm->prepare()
        ]);
    }

    public function editAction()
    {
        $this->layout()->setTemplate('user/layout/layout');
        $id = $this->params()->fromRoute('id');

        if (empty($id) && !$this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('protocol', ['action' => 'index']);
        }

        try {
            if ($this->getRequest()->isPost()) {
                $id = $this->getRequest()->getPost()->id;
            }

            $protocol = $this->protocolTable->getBy([
                'id' => $id,
                'user_id' => $this->identity()->id
            ]);
        } catch (Exception $exception) {
            return $this->redirect()->toRoute('protocol', ['action' => 'index']);
        }

        $this->protocolForm->bind($protocol);

        $viewData = ['id' => $id, 'form' => $this->protocolForm->prepare()];

        if (!$this->getRequest()->isPost()) {
            return $viewData;
        }

        $this->protocolForm->setData($this->getRequest()->getPost());

        if (!$this->protocolForm->isValid()) {
            return $viewData;
        }

        $data = (array) $this->protocolForm->getData();

        $this->protocolTable->save($data);

        return $this->redirect()->toRoute('protocol', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $this->layout()->setTemplate('user/layout/layout');
        $id = $this->params()->fromRoute('id');

        if (empty($id)) {
            return $this->redirect()->toRoute('protocol', ['action' => 'index']);
        }

        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');

            if ($del == 'Yes') {
                $id = $this->getRequest()->getPost('id');
                $this->protocolTable->delete($id);
            }

            return $this->redirect()->toRoute('protocol');
        }

        return [
            'id' => $id,
            'protocol' => $this->protocolTable->getBy([
                'id' => $id,
                'user_id' => $this->identity()->id
            ]),
        ];
    }

    public function printAction()
    {
        $id = $this->params()->fromRoute('id');

        if (empty($id) && !$this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('protocol', ['action' => 'index']);
        }

        try {
            if ($this->getRequest()->isPost()) {
                $id = $this->getRequest()->getPost()->id;
            }

            $protocol = $this->protocolTable->getBy([
                'id' => $id,
                'user_id' => $this->identity()->id
            ]);
        } catch (Exception $exception) {
            return $this->redirect()->toRoute('protocol', ['action' => 'index']);
        }

        $viewModel = new ViewModel(['protocol' => $protocol]);
        $viewModel->setTemplate('protocol/layout/print');

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($this->renderer->render($viewModel));
        $id = (int) $protocol->id;
        $filename = 'protocolo-' . $id . '.pdf';

        $mpdf->Output($filename, 'I');
    }
}
