<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Application\Model\ClientTable;
use Application\Model\ProtocolTable;
use Zend\ServiceManager\Factory\InvokableFactory;
use Application\Model\Factory\ClientTableFactory;
use Application\Model\Factory\ProtocolTableFactory;
use Application\Controller\Factory\ClientControllerFactory;
use Application\Controller\Factory\ProtocolControllerFactory;

return [
    'router' => [
        'routes' => [
            'application' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'client' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/client[/:action[/:id]][/]',
                    'defaults' => [
                        'controller' => Controller\ClientController::class,
                        'action' => 'index',
                    ],
                    'contraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '\d+'
                    ],
                ],
            ],
            'protocol' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/protocol[/:action[/:id]][/]',
                    'defaults' => [
                        'controller' => Controller\ProtocolController::class,
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
            Controller\IndexController::class => InvokableFactory::class,
            Controller\ClientController::class => ClientControllerFactory::class,
            Controller\ProtocolController::class => ProtocolControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            ClientTable::class => ClientTableFactory::class,
            ProtocolTable::class => ProtocolTableFactory::class,
        ]
    ],
    'view_manager' => [
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/client/index' => __DIR__ . '/../view/application/client/index.phtml',
            'application/client/edit' => __DIR__ . '/../view/application/client/edit.phtml',
            'application/client/register' => __DIR__ . '/../view/application/client/register.phtml',
            'application/client/delete' => __DIR__ . '/../view/application/client/delete.phtml',
            'application/protocol/index' => __DIR__ . '/../view/application/protocol/index.phtml',
            'application/protocol/edit' => __DIR__ . '/../view/application/protocol/edit.phtml',
            'application/protocol/register' => __DIR__ . '/../view/application/protocol/register.phtml',
            'application/protocol/delete' => __DIR__ . '/../view/application/protocol/delete.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ]
    ],
];
