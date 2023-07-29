<?php

namespace User\Model;

use Core\Model\AbstractCoreModelTable;
use Zend\Crypt\Password\Bcrypt;

class UserTable extends AbstractCoreModelTable
{

    public function save(array $data)
    {

        if (isset($data['password'])) {
            $data['password'] = (new Bcrypt())->create($data['password']);
        }

        return parent::save($data);
    }

    public function getUserByEmail($email)
    {
        return $this->getBy(['email' => $email]);
    }
}
