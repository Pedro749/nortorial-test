<?php

namespace Application\Controller\Factory;

use Client\Model\ClientTable;
use Protocol\Model\ProtocolTable;
use Interop\Container\ContainerInterface;
use Application\Controller\IndexController;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $clientTable = $container->get(ClientTable::class);
        $protocolTable = $container->get(ProtocolTable::class);

        return new IndexController($clientTable, $protocolTable);
    }
}
