<?php

namespace Application\Model\Factory;

use Application\Model\Client;
use Application\Model\ClientTable;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ClientTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $adapter = $container->get(Adapter::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Client());

        $tableGateway = new TableGateway('clients', $adapter, null, $resultSetPrototype);

        return new ClientTable($tableGateway);
    }
}
