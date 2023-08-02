<?php

namespace Protocol\Controller\Factory;

use Protocol\Form\ProtocolForm;
use Protocol\Model\ProtocolTable;
use Protocol\Controller\IndexController;
use Zend\View\Renderer\RendererInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $protocolForm = new ProtocolForm();
        $protocoltTable = $container->get(ProtocolTable::class);
        $renderer = $container->get(RendererInterface::class);

        return new IndexController($protocolForm, $protocoltTable, $renderer);
    }
}
