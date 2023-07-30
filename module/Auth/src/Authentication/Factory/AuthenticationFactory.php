<?php

namespace Auth\Authentication\Factory;

use User\Model\UserTable;
use Auth\Authentication\Adapter;
use Zend\Authentication\Storage\Session;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthenticationFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $session = new Session();

        $user = $container->get(UserTable::class);

        return new AuthenticationService($session, new Adapter($user));
    }
}
