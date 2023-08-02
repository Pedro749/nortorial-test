<?php

namespace Application\Controller\Factory;

use Application\Form\ClientForm;
use Application\Model\ClientTable;
use Zend\Db\Adapter\Adapter;
use Application\Controller\ClientController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ClientControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $adapter = $container->get(Adapter::class);


        $clientForm = new ClientForm($adapter);

        $clientTable = $container->get(ClientTable::class);
        return new ClientController($clientForm, $clientTable);
    }
}
