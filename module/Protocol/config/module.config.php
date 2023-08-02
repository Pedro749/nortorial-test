<?php

namespace Protocol;

use Zend\Router\Http\Segment;
use Protocol\Model\ProtocolTable;
use Zend\View\Renderer\RendererInterface;
use Protocol\Model\Factory\ProtocolTableFactory;
use Protocol\Controller\Factory\IndexControllerFactory;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'protocol' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/protocol[/:action[/:id]][/]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                    'contraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '\d+'
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => IndexControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'protocol/' => __DIR__ . '/../view/protocol/index/index.phtml',
            'protocol/edit' => __DIR__ . '/../view/protocol/index/edit.phtml',
            'protocol/layout/print' => __DIR__ . '/../view/protocol/layout/print.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            ProtocolTable::class => ProtocolTableFactory::class,
            RendererInterface::class => InvokableFactory::class
        ]
    ],
];
