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
                'type' => Literal::class,
                'options' => [
                    'route' => '/client',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
                'my_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '[/:action]',
                            'contraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                        ],
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
            'client/' => __DIR__ . '/../view/client/index/index.phtml'
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
