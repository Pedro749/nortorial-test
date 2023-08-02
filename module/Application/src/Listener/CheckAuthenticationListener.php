<?php

namespace Application\Listener;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\Event;
use Application\Controller\IndexController;
use Application\Controller\ClientController;
use Application\Controller\ProtocolController;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\AbstractListenerAggregate;

class CheckAuthenticationListener extends AbstractListenerAggregate
{

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $sharedEvents = $events->getSharedManager();

        $this->listeners[] = $sharedEvents->attach(
            IndexController::class,
            MvcEvent::EVENT_DISPATCH,
            [$this, 'dispatch'],
            $priority
        );

        $this->listeners[] = $sharedEvents->attach(
            ClientController::class,
            MvcEvent::EVENT_DISPATCH,
            [$this, 'dispatch'],
            $priority
        );

        $this->listeners[] = $sharedEvents->attach(
            ProtocolController::class,
            MvcEvent::EVENT_DISPATCH,
            [$this, 'dispatch'],
            $priority
        );
    }

    public function dispatch(Event $event)
    {
        $controller = $event->getTarget();

        if (!$controller->identity()) {
            $controller->flashMessenger('Para acessar você deve fazer login.');

            return $controller->redirect()->toRoute('auth.login');
        }
    }
}
