<?php

namespace Protocol\Model;

use Core\Model\AbstractCoreModelTable;

class ProtocolTable extends AbstractCoreModelTable
{
    public function save(array $data)
    {
        return parent::save($data);
    }
}