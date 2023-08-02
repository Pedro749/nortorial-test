<?php

namespace Client;

use Zend\EventManager\EventInterface;
use Client\Listener\CheckAuthenticationListener;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(EventInterface $e)
    {
        $eventManager = $e->getApplication()->getEventManager();

        (new CheckAuthenticationListener())->attach($eventManager, 99);
    }
}
