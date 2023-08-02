<?php

namespace Protocol\Model\Factory;

use Protocol\Model\Protocol;
use Protocol\Model\ProtocolTable;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProtocolTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $adapter = $container->get(Adapter::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Protocol());

        $tableGateway = new TableGateway('protocols', $adapter, null, $resultSetPrototype);

        return new ProtocolTable($tableGateway);
    }
}
