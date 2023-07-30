<?php

namespace Auth\Authentication;

use User\Model\UserTable;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;
use Zend\Authentication\Adapter\AdapterInterface;

class Adapter implements AdapterInterface
{
    protected $email;
    protected $password;
    private $userTable;

    public function __construct(UserTable $userTable)
    {
        $this->userTable = $userTable;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function authenticate()
    {
        if ($user = $this->userTable->getUserByEmail($this->email)) {
            $bcrypt = new Bcrypt();

            if ($bcrypt->verify($this->password, $user->password)) {
                return new Result(Result::SUCCESS, $user);
            }
        }

        return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, [
            'Login ou senha inválido!'
        ]);
    }
}
