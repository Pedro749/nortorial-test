<?php

namespace Client\Controller\Factory;

use Client\Form\ClientForm;
use Client\Model\ClientTable;
use Zend\Db\Adapter\Adapter;
use Client\Controller\IndexController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $adapter = $container->get(Adapter::class);
        $clientForm = new ClientForm($adapter);
        $clientTable = $container->get(ClientTable::class);

        return new IndexController($clientForm, $clientTable);
    }
}
