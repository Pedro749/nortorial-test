<?php

namespace Application\Controller\Factory;

use Application\Form\ProtocolForm;
use Application\Model\ProtocolTable;
use Application\Controller\ProtocolController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProtocolControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $protocolForm = new ProtocolForm();
        $protocoltTable = $container->get(ProtocolTable::class);

        return new ProtocolController($protocolForm, $protocoltTable);
    }
}
