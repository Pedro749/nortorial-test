<?php

namespace Client\Model;

use Core\Model\AbstractCoreModelTable;

class ClientTable extends AbstractCoreModelTable
{
    public function save(array $data)
    {
        return parent::save($data);
    }
}
