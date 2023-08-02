<?php

namespace Client;

use Client\Model\ClientTable;
use Zend\Router\Http\Segment;
use Zend\Router\Http\Literal;
use Client\Model\Factory\ClientTableFactory;
use Client\Controller\Factory\IndexControllerFactory;

return [
    'router' => [
        'routes' => [
            'client' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/client[/:action[/:id]][/]',
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
            'client/' => __DIR__ . '/../view/client/index/index.phtml',
            'client/edit' => __DIR__ . '/../view/client/index/edit.phtml',
            'client/paginator' => __DIR__ . '/../view/client/index/paginator.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            ClientTable::class => ClientTableFactory::class,
        ]
    ],
];
