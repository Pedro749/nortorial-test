<?php

namespace Client\Model;

use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;
use Core\Model\AbstractCoreModelTable;

class ClientTable extends AbstractCoreModelTable
{
    public function findAll(array $params, $paginated = false)
    {
        if ($paginated) {
            return $this->fetchPaginatedResults($params);
        }

        return $this->tableGateway->select($params);
    }

    private function fetchPaginatedResults(array $params)
    {
        $select = new Select($this->tableGateway->getTable());
        $select->where($params)->order('id DESC');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Client());

        $paginatorAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter(),
            $resultSetPrototype
        );

        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }
}
